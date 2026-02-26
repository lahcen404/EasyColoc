<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Membership;
use App\Enums\InvitationStatus;
use App\Mail\InviteRoommate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;

class InvitationController extends Controller
{
    // show form
    public function create(): View
    {
        return view('invitations.create');
    }

    // form submission to create an invitation
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // get current user ownership status
        $membership = Auth::user()->memberships()
            ->where('is_owner', true)
            ->whereNull('left_at')
            ->first();

        if (!$membership) {
            return redirect()->route('dashboard')->with('error', 'only house owners can send invitations!!!');
        }

        // creeate the invitation
        $invitation = Invitation::create([
            'email' => $request->email,
            'token' => Str::random(32),
            'colocation_id' => $membership->colocation_id,
            'status' => InvitationStatus::PENDING,
            'expires_at' => now()->addDays(7),
        ]);

        try {
            Mail::to($request->email)->send(new InviteRoommate($invitation));
            return redirect()->route('dashboard')->with('success', "Access token dispatched to {$request->email}.");
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('success', "Token generated, but email delivery failed. Manual link: " . route('invitations.join', $invitation->token));
        }
    }

    // validation tokeen
    public function join(string $token): RedirectResponse
    {
        // 1. Find the token in the database
        $invitation = Invitation::where('token', $token)
            ->where('status', InvitationStatus::PENDING)
            ->where('expires_at', '>', now())
            ->first();

        if (!$invitation) {
            return redirect()->route('dashboard')->with('error', 'Invalid or expired access token.');
        }

        $user = Auth::user();

        // check if user is already part of an active house registry
        $hasActiveMembership = $user->memberships()
            ->whereNull('left_at')
            ->exists();

        if ($hasActiveMembership) {
            return redirect()->route('dashboard')->with('error', 'Security Violation: You are already part of an active house registry. Leave your current house to join a new one.');
        }

        try {
            DB::beginTransaction();

            Membership::create([
                'user_id' => $user->id,
                'colocation_id' => $invitation->colocation_id,
                'is_owner' => false,
                'joined_at' => now(),
            ]);

            $invitation->update([
                'status' => InvitationStatus::ACCEPTED
            ]);

            DB::commit();

            return redirect()->route('dashboard')->with('success', "Welcome to the {$invitation->colocation->name} cluster.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard')->with('error', 'Initialization failure. The handshake could not be completed.');
        }
    }
}
