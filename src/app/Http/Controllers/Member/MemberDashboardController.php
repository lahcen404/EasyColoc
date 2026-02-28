<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
    /**
     * Display the house dashboard with real-time settlement logic.
     */
    public function index(): View
    {
        $membership = auth()->user()->memberships()
            ->with([
                'colocation.expenses',
                'colocation.memberships.user',
                'paidExpenses',
                'sentPayments',     // track money sent to others
                'receivedPayments'  // track money received from others
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

            $myRelevantExpenses = $colocation->expenses()
                ->where('date', '>=', $membership->joined_at)
                ->get();

            $myFairShare = $memberCount > 0 ? round($myRelevantExpenses->sum('amount') / $memberCount, 2) : 0;

            // calculate balance for current user
            $paidByMe = $membership->paidExpenses->sum('amount');
            $sentByMe = $membership->sentPayments()->where('is_confirmed', true)->sum('amount');
            $receivedByMe = $membership->receivedPayments()->where('is_confirmed', true)->sum('amount');

            $balance = ($paidByMe + $sentByMe) - ($myFairShare + $receivedByMe);

            $totalHouseExpenses = $colocation->expenses->sum('amount');

            // algo to determine who owes who based on balances
            $balances = [];
            foreach ($activeMemberships as $m) {
                $relevantSum = $colocation->expenses()->where('date', '>=', $m->joined_at)->sum('amount');
                $mFairShare = $memberCount > 0 ? round($relevantSum / $memberCount, 2) : 0;

                $mPaid = $m->paidExpenses->sum('amount');
                $mSent = $m->sentPayments()->where('is_confirmed', true)->sum('amount');
                $mReceived = $m->receivedPayments()->where('is_confirmed', true)->sum('amount');

                $mStatus = ($mPaid + $mSent) - ($mFairShare + $mReceived);

                $balances[] = [
                    'name' => $m->user->name,
                    'id' => $m->id,
                    'balance' => round($mStatus, 2)
                ];
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
