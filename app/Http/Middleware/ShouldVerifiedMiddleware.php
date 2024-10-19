<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShouldVerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (empty($request->user()->email_verified_at) || empty($request->user()->phone_verified_at)) {
            return redirect()->route('business.profile.verification')->withErrors('Please verified email and phone.');
        }

        return $next($request);
    }
}
