<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ColocationMemberController extends Controller
{
    // let a member leave the house
    public function leave(): RedirectResponse
    {
        $user = Auth::user();
        $membership = $user->memberships()->whereNull('left_at')->firstOrFail();

        // owner is not allowed to leave
        if ($membership->is_owner) {
            return redirect()->back()->with('error', 'Owners cannot leave. You must cancel the house or give power to someone else.');
        }

        return $this->processDeparture($membership, "You have successfully left the house!!!", true);
    }

    // let the owner remove a roommate
    public function remove(Membership $membership): RedirectResponse
    {
        // check if current user is the owner
        $me = Auth::user()->memberships()
            ->where('is_owner', true)
            ->whereNull('left_at')
            ->firstOrFail();

        // make sure the member is actually in this house
        if ($membership->colocation_id !== $me->colocation_id) {
            return redirect()->back()->with('error', 'Unauthorized: Member does not belong to your house.');
        }

        // owner cannot kick themselves
        if ($membership->id === $me->id) {
            return redirect()->back()->with('error', 'Security Alert: You cannot remove yourself.');
        }

        return $this->processDeparture($membership, "Roommate successfully removed from the registry.", false, $me);
    }

    // logic to handle reputation and debts when someone leaves
    private function processDeparture(Membership $membership, $message, bool $isSelfDeparture, $ownerMembership = null)
    {
        try {
            
            DB::beginTransaction();

            $colocation = $membership->colocation;

            // find people still in the house
            $activeMembers = $colocation->memberships()->whereNull('left_at')->get();

            // calculate the fair share based on join date
            $mTotalFairShare = 0;
            foreach ($colocation->expenses as $expense) {
                if ($expense->date >= $membership->joined_at) {
                    $peoplePresent = $colocation->memberships->filter(function($otherM) use ($expense) {
                        return $otherM->joined_at <= $expense->date && ($otherM->left_at === null || $otherM->left_at >= $expense->date);
                    })->count();
                    $mTotalFairShare += ($peoplePresent > 0) ? ($expense->amount / $peoplePresent) : 0;
                }
            }

            // get spending and payment data
            $paidAtShop = $membership->paidExpenses->sum('amount');
            $confirmedSent = $membership->sentPayments()->where('is_confirmed', true)->sum('amount');
            $confirmedReceived = $membership->receivedPayments()->where('is_confirmed', true)->sum('amount');

            // check the final balance
            $finalBalance = ($paidAtShop + $confirmedSent) - ($mTotalFairShare + $confirmedReceived);

            // logic for debt handling and reputation adjustment
            if ($finalBalance < -0.01) {
                $debtAmount = abs($finalBalance);

                if ($isSelfDeparture) {
                    // bad reputation if you leave with debt
                    $membership->user->decrement('reputation_score', 2);

                    // share the debt with the rest of the house
                    $category = Category::firstOrCreate(['name' => 'Adjustment']);
                    Expense::create([
                        'title' => "Debt Redistribution: " . $membership->user->name,
                        'amount' => $debtAmount,
                        'date' => now(),
                        'payer_member_id' => $activeMembers->where('id', '!=', $membership->id)->first()->id,
                        'colocation_id' => $colocation->id,
                        'category_id' => $category->id,
                    ]);
                } else {
                    // if owner kicks you, owner must pay your debt
                    Payment::create([
                        'sender_id' => $ownerMembership->id,
                        'receiver_id' => $membership->id,
                        'amount' => $debtAmount,
                        'date' => now(),
                        'is_confirmed' => true,
                    ]);
                }
            } else {
                // good reputation if you leave with no debt
                $membership->user->increment('reputation_score');
            }

            // set the leave date
            $membership->update(['left_at' => now()]);

            // save everything
            DB::commit();
            return redirect()->route('dashboard')->with('success', $message);

        } catch (\Exception $e) {
            // cancel if error occurs
            DB::rollBack();
            return redirect()->back()->with('error', 'System error during departure.');
        }
    }
}
