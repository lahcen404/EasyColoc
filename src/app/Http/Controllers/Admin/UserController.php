<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index()
    {

        $users = User::where('id', '!=', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // ban user
    public function toggleBan(User $user)
    {

        $user->is_banned = !$user->is_banned;
        $user->save();

        $status = $user->is_banned ? 'Banned' : 'Activated';

        return redirect()->back()->with('success', "Account for {$user->name} has been successfully {$status}.");
    }
}
