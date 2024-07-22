<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            $admin = Auth::guard('admin')->user();

        if ($admin && $admin->role && $admin->role->name === 'Super Admin') {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized User'
        ], 403);
    }


        return response()->json([
            'message' => 'Unauthorized User'
        ], 403);
    }
}
