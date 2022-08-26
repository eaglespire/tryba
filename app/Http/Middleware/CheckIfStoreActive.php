<?php

namespace App\Http\Middleware;

use App\Models\Storefront;
use Closure;
use Illuminate\Http\Request;

class CheckIfStoreActive
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

        $store = Storefront::where('store_url',$request->id)->first();
        if($store->storeActive == true)
        {
            return $next($request);
        }else{
            return response()->view('errors.custom',[
                'title' => 'Not Available',
                'error' => 'Store is currently not active'
            ]);
        }
    }
}
