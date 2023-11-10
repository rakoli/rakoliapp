<?php

namespace App\Http\Middleware;

use App\Utils\Enums\UserTypeEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShouldCompleteRegistrationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->registration_step != 0){
            if($request->user()->type == UserTypeEnum::AGENT->value){
                return redirect()->route('registration.agent');
            }elseif ($request->user()->type == UserTypeEnum::VAS->value){
                return redirect()->route('registration.vas');
            }else{
                return redirect()->route('logout');
            }
        }
        return $next($request);
    }
}
