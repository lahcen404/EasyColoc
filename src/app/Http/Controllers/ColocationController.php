<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Membership;
use App\Enums\ColocationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * This controller manages the lifecycle of a Colocation.
 * It handles the transition from "Simple User" to "House Member".
 */
class ColocationController extends Controller
{
    // view
    public function create(): View
    {
        return view('colocations.create');
    }

   // Create colcoation
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:100|min:3',
        ]);

         try {
            DB::beginTransaction();


            $coloc = Colocation::create([
                'name' => $request->name,
                'status' => ColocationStatus::ACTIVE,
            ]);


            Membership::create([
                'user_id' => auth()->id(),
                'colocation_id' => $coloc->id,
                'is_owner' => true,
                'joined_at' => now(),
            ]);

            DB::commit();

             return redirect()->route('dashboard')->with('success', 'House Createed successfully!!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error in Creating !');
        }
    }

    public function cancel(): RedirectResponse
    {
        $user = Auth::user();

        // onlyy owner can cancel
        $ownerMembership = $user->memberships()
            ->where('is_owner', true)
            ->whereNull('left_at')
            ->firstOrFail();

        $colocation = $ownerMembership->colocation;

        try {
            DB::beginTransaction();

            $activeMemberships = $colocation->memberships()->whereNull('left_at')->with(['user', 'paidExpenses'])->get();
            $totalExpenses = $colocation->expenses->sum('amount');
            $memberCount = $activeMemberships->count();
            $fairShare = $memberCount > 0 ? round($totalExpenses / $memberCount, 2) : 0;


            // updaate reputations and mark all as left
            foreach ($activeMemberships as $membership) {
                $memberUser = $membership->user;
                $paidByMember = $membership->paidExpenses->sum('amount');
                $balance = $paidByMember - $fairShare;


                if ($balance < -0.01) {
                    $memberUser->decrement('reputation_score');
                } else {
                    $memberUser->increment('reputation_score');
                }


                $membership->update(['left_at' => now()]);
            }


            $colocation->update(['status' => ColocationStatus::CANCELLED]);

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'House registry cancelle!!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error in cancellation !!');
        }
    }
}
