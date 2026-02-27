<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\Member\ColocationMemberController;
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Member\ExpenseController;
use App\Http\Controllers\Member\InvitationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');

    // colocation routes
    Route::get('/colocation/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::post('/colocation/create', [ColocationController::class, 'store'])->name('colocations.store');

    // Leave colocation route
    Route::post('/colocation/leave', [ColocationMemberController::class, 'leave'])->name('colocations.leave');

    // cancel colocation
    Route::post('/colocation/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');


    // invitation routes
    Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::get('/join/{token}', [InvitationController::class, 'join'])->name('invitations.join');

    // expense routes
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');

    // profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/toggle-ban', [UserController::class, 'toggleBan'])->name('users.toggle-ban');
    });
});

require __DIR__.'/auth.php';
