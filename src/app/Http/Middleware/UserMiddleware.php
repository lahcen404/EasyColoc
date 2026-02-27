<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        // checck if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }


        if (auth()->user()->role === UserRole::ADMIN) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have user accesss !!!');
        }


        if (auth()->user()->role === UserRole::USER) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
