<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use App\Enums\ColocationStatus;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the global administrative console.
     */
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'active_colocations' => Colocation::where('status', ColocationStatus::ACTIVE)->count(),
            'total_flow' => Expense::sum('amount'),
            'banned_users' => User::where('is_banned', true)->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}
