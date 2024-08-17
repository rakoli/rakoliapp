<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('APP_ENV') == 'testing'){
            return $next($request);
        }
        if (empty($request->user()->business->package_code) || $request->user()->business->package_expiry_at < Carbon::now()) {
            return redirect()->route('business.subscription')->withErrors("You don't have permission to access it, Please upgrade you plan.");
        } else {
            if(request()->is('exchange/*')){
                if(!validateSubscription('float exchange')){
                    return redirect()->route('home')->withErrors("You don't have permission to access it, Please upgrade you plan.");
                }
            } elseif(request()->is('agency/networks*')){
                if(!validateSubscription('tills')){
                    return redirect()->route('home')->withErrors("You don't have permission to access it, Please upgrade you plan.");
                }
            } elseif(request()->is('agency/loans*')){
                if(!validateSubscription('loan management')){
                    return redirect()->route('home')->withErrors("You don't have permission to access it, Please upgrade you plan.");
                }
            } elseif(request()->is('opportunity/*')){
                if(!validateSubscription('VAS opportunity')){
                    return redirect()->route('home')->withErrors("You don't have permission to access it, Please upgrade you plan.");
                }
            } elseif(request()->is('business/branches*')){
                if(!validateSubscription('branches')){
                    return redirect()->route('home')->withErrors("You don't have permission to access it, Please upgrade you plan.");
                }
            }
        }
        return $next($request);
    }
}
