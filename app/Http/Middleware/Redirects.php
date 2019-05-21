<?php
/**
 * Controls the custom 301 redirects added in the CMS
 */
namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;

class Redirects
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->path() . ($request->getQueryString() ? '?' . $request->getQueryString() : '');
        if (!$request->is('admin/*') && $redirect = Redirect::hasRedirect(trim($path)))
            return redirect($redirect->redirect_to, $redirect->code);

        return $next($request);
    }
}
