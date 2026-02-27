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
        $paidByMe = 0;
        $balance = 0;
        $settlements = [];

        if ($membership) {
            $colocation = $membership->colocation;

            // active membeers
            $activeMemberships = $colocation->memberships()
                ->whereNull('left_at')
                ->with(['user', 'paidExpenses'])
                ->get();

            $memberCount = $activeMemberships->count();


            $myRelevantExpenses = $colocation->expenses()
                ->where('date', '>=', $membership->joined_at)
                ->get();

            $myFairShare = $memberCount > 0 ? round($myRelevantExpenses->sum('amount') / $memberCount, 2) : 0;

            $paidByMe = $membership->paidExpenses->sum('amount');

            $balance = $paidByMe - $myFairShare;

            
            $totalHouseExpenses = $colocation->expenses->sum('amount');


            $balances = [];
            foreach ($activeMemberships as $m) {

                $relevantSum = $colocation->expenses()
                    ->where('date', '>=', $m->joined_at)
                    ->sum('amount');

                $mFairShare = $memberCount > 0 ? round($relevantSum / $memberCount, 2) : 0;
                $mPaid = $m->paidExpenses->sum('amount');

                $balances[] = [
                    'name' => $m->user->name,
                    'id' => $m->id,
                    'balance' => round($mPaid - $mFairShare, 2)
                ];
            }

            // algo to determine who owes who based on balances
            $debtors = array_filter($balances, fn($b) => $b['balance'] < -0.01);
            $creditors = array_filter($balances, fn($b) => $b['balance'] > 0.01);

            foreach ($debtors as &$debtor) {
                foreach ($creditors as &$creditor) {
                    // Caalculate transfer amount
                    $amount = min(abs($debtor['balance']), $creditor['balance']);

                    if ($amount > 0.01) {
                        $settlements[] = [
                            'from' => $debtor['name'],
                            'to' => $creditor['name'],
                            'amount' => round($amount, 2),
                            'to_id' => $creditor['id']
                        ];

                        // updaaate balances
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
            'paidByMe',
            'balance',
            'settlements'
        ));
    }
}
