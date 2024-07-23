<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ,$roles): Response
    {
        $admin = Auth::guard('admin')->user();

        // تحقق من أن هناك مستخدم
        if (!$admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // تحويل أسماء الأدوار إلى IDs
        $roleIds = Role::whereIn('name', $roles)->pluck('id')->toArray();

        // تحقق مما إذا كان لدى المستخدم أي من الأدوار المطلوبة
        if (!in_array($admin->role_id, $roleIds)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }

}
