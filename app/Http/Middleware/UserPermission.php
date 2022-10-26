<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role = 'user')
    {
        if ($request->route()->getName() === 'admin.login') {
            return $next($request);
        }

        if (!$request->user()) {
            if ($role === 'admin') {
                return redirect()->route('admin.login');
            }
            return redirect()->route('login');
        }

        if (!$request->user()->hasRole($role)) {
            return redirect('/');
        }

        return $next($request);
    }
}
