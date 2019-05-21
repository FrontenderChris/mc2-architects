<?php
namespace App\Http\Middleware;

use Closure;

class HttpsProtocol
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && env('SSL_ENABLE')) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}