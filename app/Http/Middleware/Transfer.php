<?php

namespace App\Http\Middleware;

use App\Models\Countrysupported;
use App\Models\Settings;
use Closure;
use Auth;

class Transfer
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
        $set=Settings::first();
        $xf=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if($set->transfer==1){
            if($xf->transfer==1){
                if(Auth::guard('user')->user()->transfer_pin!=null)
                {
                    return $next($request);
                }else{
                    return redirect()->route('user.notransferpin');
                }
            }else{
                return $next($request);
            }
        }else{
            return $next($request);
        }
 

    }
}
