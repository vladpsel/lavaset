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
    public function handle(Request $request, Closure $next, $role = 'admin')
    {
        if ($request->route()->getName() === 'admin.login') {
            return $next($request);
        }
        dd($request->user());
//        if (!$request->user()) {
//            return redirect()->route('admin.login');
//        }
        return $next($request);
    }
}
