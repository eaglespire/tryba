<?php

namespace App\Providers;

use App\Models\Customdomain;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Models\Storefront;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->configureRateLimiting();

        $this->routes(function (Request $request) {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            $domain = $request->getSchemeAndHttpHost();
            if($domain=="https://tryba.market"){
                Route::middleware('market')
                ->namespace($this->namespace)
                ->group(base_path('routes/market.php'));
            }else if($domain=="https://compliance.tryba.io")
                Route::middleware('market')
                ->namespace($this->namespace)
                ->group(base_path('routes/compliance.php'));
            else{
                $tenant = Customdomain::where('domain', $domain)->count();
                if ($tenant == 1) {
                    Route::middleware('domain')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/domain.php'));
                } else {
                    Route::middleware('web')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/web.php'));
                }
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        RateLimiter::for('global', function (Request $request) {
            return $request->user()
            ? Limit::perMinute(50)->by($request->user()->id)
            : Limit::perMinute(2)->by($request->ip());
        });
    }
}