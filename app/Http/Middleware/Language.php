<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Torann\GeoIP\Facades\GeoIP;
use Illuminate\Support\Facades\Session;

class Language
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
            $lan=['dk','de','es','fi','fr','hu','it','lt','lv','nl','pl','ro','sl','ee','se'];
            $locale = strtolower(GeoIP::getLocation()->iso_code);
            if(in_array($locale, $lan)){
                App::setLocale($locale);
                session()->put('locale', $locale);
            }
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }
        return $next($request);
    }
}
