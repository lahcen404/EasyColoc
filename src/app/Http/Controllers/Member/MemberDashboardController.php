<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
    // show dashboard
    public function index(): View
    {
        $membership = auth()->user()->memberships()
            ->with([
                'colocation.expenses',
                'colocation.memberships.user',
                'paidExpenses',
                'sentPayments',     
                'receivedPayments'
            ])
            ->whereNull('left_at')
            ->first();

        $totalHouseExpenses = 0;
        $memberCount = 0;
        $balance = 0;
        $settlements = [];
        $pendingIncoming = collect();

        if ($membership) {
            $colocation = $membership->colocation;

            // active membeers
            $activeMemberships = $colocation->memberships()
                ->whereNull('left_at')
                ->with(['user', 'paidExpenses', 'sentPayments', 'receivedPayments'])
                ->get();

            $memberCount = $activeMemberships->count();

            // fetch payments awaiting current user's confirmation
            $pendingIncoming = $membership->receivedPayments()
                ->where('is_confirmed', false)
                ->with('sender.user')
                ->get();

            // calculate balance for current user

            $totalHouseExpenses = $colocation->expenses->sum('amount');

            // algo to determine who owes who based on balances
            $balances = [];
            foreach ($activeMemberships as $m) {

                $mTotalFairShare = 0;
                foreach ($colocation->expenses as $expense) {

                    if ($expense->date >= $m->joined_at) {

                        // calculate fair share based on who was present at the time of the expense
                        $peoplePresentAtTime = $colocation->memberships->filter(function($otherM) use ($expense) {
                            return $otherM->joined_at <= $expense->date && ($otherM->left_at === null || $otherM->left_at >= $expense->date);
                        })->count();

                        $mTotalFairShare += ($peoplePresentAtTime > 0) ? ($expense->amount / $peoplePresentAtTime) : 0;
                    }
                }

                $mPaid = $m->paidExpenses->sum('amount');
                $mSent = $m->sentPayments()->where('is_confirmed', true)->sum('amount');
                $mReceived = $m->receivedPayments()->where('is_confirmed', true)->sum('amount');

                $mStatus = ($mPaid + $mSent) - ($mTotalFairShare + $mReceived);

                $balances[] = [
                    'name' => $m->user->name,
                    'id' => $m->id,
                    'balance' => round($mStatus, 2)
                ];

                // set the balance for the current logged-in user
                if ($m->id === $membership->id) {
                    $balance = $mStatus;
                }
            }

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
                            'to_id' => $creditor['id'],
                            'amount' => round($amount, 2)
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
            'balance',
            'settlements',
            'pendingIncoming'
        ));
    }
}
