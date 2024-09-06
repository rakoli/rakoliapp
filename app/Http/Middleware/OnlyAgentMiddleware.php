<?php

namespace App\Http\Middleware;

use App\Utils\Enums\UserTypeEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyAgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array($request->user()->type, [UserTypeEnum::AGENT->value,UserTypeEnum::SALES->value])) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
