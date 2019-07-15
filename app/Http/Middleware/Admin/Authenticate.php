<?php
/*
* ADMIN ONLY
* This middleware is used to authenticate users when trying to access routes from the admin namespace
*/
namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (hasLoginPackage()) {
            if (\Auth::check() && \Auth::user()->role->slug != \Modulatte\Login\Models\Role::ROLE_ADMIN) {
                return redirect('/');
            }
        }

        if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('admin/login');
            }
        }

        return $next($request);
    }
}
