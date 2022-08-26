<?php

namespace App\Http\Middleware;

use App\Models\Website;
use Closure;
use Illuminate\Http\Request;

class WebsiteisNotAvailble
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
        
        $website = Website::where('websiteUrl',$request->id)->first();
        if($website->status == 1)
        {
            return $next($request);
        }else{
            return response()->view('errors.custom',[
                'title' => 'Not Available',
                'error' => 'Website is currently not active'
            ]);
        }
    }
}
