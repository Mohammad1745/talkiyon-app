<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Student
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role==STUDENT_ROLE) {
            return $next($request);
        }
        return response()->json(['message' => 'Unauthorized']);
    }
}
