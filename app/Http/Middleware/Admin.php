<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Application|RedirectResponse|Redirector|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()) {
            if (Auth::user()->role==ADMIN_ROLE) {
                return $next($request);
            }
            Auth::logout();
        }

        return redirect(route('login'));
    }
}
