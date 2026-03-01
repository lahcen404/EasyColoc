<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
   // store new payment
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'receiver_id' => 'required|exists:memberships,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // get sender's membership
        $senderMembership = Auth::user()->memberships()
            ->whereNull('left_at')
            ->firstOrFail();

        // user cannot pay themselves
        if ($senderMembership->id == $request->receiver_id) {
            return redirect()->back()->with('error', 'Handshake Error: You cannot pay yourself.');
        }


        Payment::create([
            'sender_id' => $senderMembership->id,
            'receiver_id' => $request->receiver_id,
            'amount' => $request->amount,
            'date' => now(),
            'is_confirmed' => false, // starts as pending for the handshake
        ]);

        return redirect()->route('dashboard')->with('success', 'Payment successfully recorded!!');
    }

    // confirm a received payment
     public function confirm(Payment $payment): RedirectResponse
    {
        $myMembership = Auth::user()->memberships()->whereNull('left_at')->firstOrFail();

        // only receiver can confirm the payment
        if ($payment->receiver_id !== $myMembership->id) {
            return redirect()->back()->with('error', 'Unauthorized confirmation attempt.');
        }

        $payment->update(['is_confirmed' => true]);

        return redirect()->route('dashboard')->with('success', 'Registry updated: Payment confirmed.');
    }
}
