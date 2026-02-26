<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class ColocationMemberController extends Controller
{
    public function leave(): RedirectResponse
    {
        $user = Auth::user();

        $membership = $user->memberships()
            ->with('colocation.expenses')
            ->whereNull('left_at')
            ->firstOrFail();

            // owner can't leave
        if ($membership->is_owner) {
            return redirect()->back()->with('error', 'Owners cannot leave. You must cancel the colocation or transfer ownership.');
        }


        $totalExpenses = $membership->colocation->expenses->sum('amount');
        $memberCount = $membership->colocation->memberships()->whereNull('left_at')->count();
        $fairShare = $memberCount > 0 ? ($totalExpenses / $memberCount) : 0;
        $paidByMe = $membership->paidExpenses->sum('amount');
        $balance = $paidByMe - $fairShare;

        try {
            DB::beginTransaction();


            if ($balance < -0.01) {
                $user->decrement('reputation_score');
            } else {
                $user->increment('reputation_score');
            }

            $membership->update(['left_at' => now()]);

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'You left the house!!!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'System error during departure.');
        }
    }
}
