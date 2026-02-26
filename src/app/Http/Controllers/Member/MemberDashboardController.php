<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\View\View;

class MemberDashboardController extends Controller
{
    public function index(): View
    {
        $membership = auth()->user()->memberships()
            ->with([
                'colocation.expenses.payer.user',
                'colocation.memberships.user'
            ])
            ->whereNull('left_at')
            ->first();

        $totalHouseExpenses = 0;
        $memberCount = 0;
        $fairShare = 0;
        $paidByMe = 0;
        $balance = 0;

        if ($membership) {
            $totalHouseExpenses = $membership->colocation->expenses->sum('amount');
            $memberCount = $membership->colocation->memberships->count();
            $fairShare = $memberCount > 0 ? ($totalHouseExpenses / $memberCount) : 0;
            $paidByMe = $membership->paidExpenses->sum('amount');
            $balance = $paidByMe - $fairShare;
        }

        return view('dashboard', compact(
            'membership',
            'totalHouseExpenses',
            'memberCount',
            'fairShare',
            'paidByMe',
            'balance'
        ));
    }
}
