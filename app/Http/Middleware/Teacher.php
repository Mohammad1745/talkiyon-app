<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Teacher
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role==TEACHER_ROLE) {
            return $next($request);
        }
        return response()->json(['message' => 'Unauthorized']);
    }
}
