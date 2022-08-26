<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Compliance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->kyc_verif_status != NULL && Auth::user()->kyc_verif_status == "APPROVED") {
            return $next($request);
        }else{
            return response()->view('errors.custom',[
                'title' => 'Compliance is currently due',
                'error' => 'Compliance is currently due, please update your account information to avoid restrictions on services we provide.'
            ]);
        }
    }
}
