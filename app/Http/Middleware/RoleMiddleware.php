<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $user = auth()->user();

        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ ban quản trị.');
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'Bạn không có quyền truy cập vào trang này.');
        }

        return $next($request);
    }
}
