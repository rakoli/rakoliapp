<?php

namespace App\Http\Middleware;

use Closure;
use Flugg\Responder\Exceptions\Http\HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DynamicAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('web')->check()) {
            // Session-based authentication successful
            return $next($request);
        } elseif (Auth::guard('sanctum')->check()) {
            // Token-based authentication successful
            Auth::shouldUse('sanctum');
            $user = $request->user();
//            dd($user);
            if (session('id') == null) {
                Auth::guard('web')->loginUsingId($user->id);
//                session()->start();
//                $request->session()->regenerate();
                setupSession($user);
            }
            return $next($request);
        } else {
            if ($request->is('api/*') || $request->wantsJson() || $request->hasHeader('Authorization')) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            // Neither authentication passed
            return redirect()->route('login');
        }
    }
}
