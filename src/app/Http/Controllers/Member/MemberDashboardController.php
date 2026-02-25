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
                'colocation',
                'colocation.memberships.user',
                'colocation.expenses'
            ])
            ->whereNull('left_at')
            ->first();

        return view('dashboard', compact('membership'));
    }
}
