<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ColocationMemberController extends Controller
{
    // leave the houuse
    public function leave(): RedirectResponse
    {
        $user = Auth::user();
        $membership = $user->memberships()->whereNull('left_at')->firstOrFail();

        // owner can't leave
        if ($membership->is_owner) {
            return redirect()->back()->with('error', 'Owners cannot leave. You must cancel the colocation or transfer ownership.');
        }

        return $this->processDeparture($membership, "You have successfully left the house!!!");
    }

    // remove a member as owner
    public function remove(Membership $membership): RedirectResponse
    {
        // only owner can remove members
        $me = Auth::user()->memberships()
            ->where('is_owner', true)
            ->whereNull('left_at')
            ->firstOrFail();

        // security check: member must be in the same house
        if ($membership->colocation_id !== $me->colocation_id) {
            return redirect()->back()->with('error', 'Unauthorized: Member does not belong to your house.');
        }

        // owner cannot remove themselves
        if ($membership->id === $me->id) {
            return redirect()->back()->with('error', 'Security Alert: You cannot remove yourself from your own house.');
        }

        return $this->processDeparture($membership, "Roommate successfully removed from the registry.");
    }


    private function processDeparture(Membership $membership, $message)
    {
        try {
            DB::beginTransaction();

            $colocation = $membership->colocation;

            // fetch active members to calculate fair share
            $memberCount = $colocation->memberships()->whereNull('left_at')->count();

            // calculate fair share based on their time in the house
            $relevantExpensesSum = $colocation->expenses()
                ->where('date', '>=', $membership->joined_at)
                ->sum('amount');

            $fairShare = $memberCount > 0 ? ($relevantExpensesSum / $memberCount) : 0;

            // calculate actual balance considering payments
            $paidAtShop = $membership->paidExpenses->sum('amount');
            $confirmedSent = $membership->sentPayments()->where('is_confirmed', true)->sum('amount');
            $confirmedReceived = $membership->receivedPayments()->where('is_confirmed', true)->sum('amount');

            // final balance logic
            $finalBalance = ($paidAtShop + $confirmedSent) - ($fairShare + $confirmedReceived);

            // update reputation based on financial status
            if ($finalBalance < -0.01) {
                $membership->user->decrement('reputation_score');
            } else {
                $membership->user->increment('reputation_score');
            }

            // close the membership
            $membership->update(['left_at' => now()]);

            DB::commit();
            return redirect()->route('dashboard')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'System error during departure.');
        }
    }
}
