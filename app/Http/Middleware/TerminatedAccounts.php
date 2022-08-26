<?php

namespace App\Http\Middleware;

use App\Models\BlockedAccounts;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TerminatedAccounts
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
        $user = Auth::guard('user')->user();
        
        if($user->isBlocked == true || BlockedAccounts::where('user_id',$user->id)->exists()){
            return redirect()->route('user.blocked');    
        }else{  
            return $next($request);
        }   
    }
}
