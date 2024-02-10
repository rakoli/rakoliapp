<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckViewParameter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Get the parameter from the route
        $parameter = $request->route('parameter');

        // Check if the parameter exists in your view files
        if (view()->exists('your.view.directory.'.$parameter)) {
            // Parameter exists, load the corresponding view
            return $next($request);
        }

        // Parameter not found, return a 404 view
        return response()->view('errors.404', [], 404);
    }
}
