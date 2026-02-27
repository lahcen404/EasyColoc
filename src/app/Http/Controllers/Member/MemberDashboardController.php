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
                'colocation.memberships.user',
                'paidExpenses'
            ])
            ->whereNull('left_at')
            ->first();

        $totalHouseExpenses = 0;
        $memberCount = 0;
        $fairShare = 0;
        $paidByMe = 0;
        $balance = 0;
        $settlements = [];

        if ($membership) {
            $colocation = $membership->colocation;

            // calculaate house expenses
            $activeMemberships = $colocation->memberships()
                ->whereNull('left_at')
                ->with(['user', 'paidExpenses'])
                ->get();

            $memberCount = $activeMemberships->count();

            // calculate total expenses paid by all members
            $totalHouseExpenses = $activeMemberships->sum(function($m) {
                return $m->paidExpenses->sum('amount');
            });

            $fairShare = $memberCount > 0 ? round($totalHouseExpenses / $memberCount, 2) : 0;

            $paidByMe = $membership->paidExpenses->sum('amount');
            $balance = $paidByMe - $fairShare;

            // Calcuulate settlements
            $balances = [];
            foreach ($activeMemberships as $m) {
                $userPaid = $m->paidExpenses->sum('amount');
                $userBalance = round($userPaid - $fairShare, 2);
                $balances[] = [
                    'name' => $m->user->name,
                    'id' => $m->id,
                    'balance' => $userBalance
                ];
            }

            $debtors = array_filter($balances, fn($b) => $b['balance'] < -0.01);
            $creditors = array_filter($balances, fn($b) => $b['balance'] > 0.01);

            foreach ($debtors as &$debtor) {
                foreach ($creditors as &$creditor) {
                    $amount = min(abs($debtor['balance']), $creditor['balance']);
                    if ($amount > 0.01) {
                        $settlements[] = [
                            'from' => $debtor['name'],
                            'to' => $creditor['name'],
                            'amount' => round($amount, 2)
                        ];
                        $debtor['balance'] += $amount;
                        $creditor['balance'] -= $amount;
                    }
                }
            }
        }

        return view('dashboard', compact(
            'membership',
            'totalHouseExpenses',
            'memberCount',
            'fairShare',
            'paidByMe',
            'balance',
            'settlements'
        ));
    }
}
