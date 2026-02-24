<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && auth()->user()->role === UserRole::ADMIN) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have admin accesss !!!');
    }
}
