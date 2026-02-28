<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\Member\ColocationMemberController;
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Member\ExpenseController;
use App\Http\Controllers\Member\InvitationController;
use App\Http\Controllers\Member\PaymentController;
use App\Http\Controllers\Member\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    // member routes
    Route::middleware('user')->group(function () {
        Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');

        // colocation routes
        Route::get('/colocation/create', [ColocationController::class, 'create'])->name('colocations.create');
        Route::post('/colocation/create', [ColocationController::class, 'store'])->name('colocations.store');

        // Leave colocation route
        Route::post('/colocation/leave', [ColocationMemberController::class, 'leave'])->name('colocations.leave');

        // cancel colocation
        Route::post('/colocation/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');

        // remove member
        Route::post('/members/{membership}/remove', [ColocationMemberController::class, 'remove'])->name('members.remove');

        // invitation routes
        Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
        Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
        Route::get('/join/{token}', [InvitationController::class, 'join'])->name('invitations.join');

        // payment routes
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');

        // category routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // expense routes
        Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
        Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    });

    // admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/toggle-ban', [UserController::class, 'toggleBan'])->name('users.toggle-ban');
    });

    // profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
