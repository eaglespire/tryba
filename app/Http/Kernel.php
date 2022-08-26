<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\XSS::class,
        // \Bepsvpt\SecureHeaders\SecureHeadersMiddleware::class,
        \App\Http\Middleware\HttpRedirect::class,
        // \App\Http\Middleware\HSTS::class,
        // \Spatie\Csp\AddCspHeaders::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \RealRashid\SweetAlert\ToSweetAlert::class,
        ],

        'api' => [
            EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'domain' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \RealRashid\SweetAlert\ToSweetAlert::class,
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
        ],
        'market' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \RealRashid\SweetAlert\ToSweetAlert::class,
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'Blocked' => \App\Http\Middleware\Blocked::class,
        'CheckStatus' => \App\Http\Middleware\CheckStatus::class,
        'demo' => \App\Http\Middleware\Demo::class,
        'Tfa' => \App\Http\Middleware\Tfa::class,
        'Language' => \App\Http\Middleware\Language::class,
        'Banks' => \App\Http\Middleware\Banks::class,
        'Transfer' => \App\Http\Middleware\Transfer::class,
        'Kyc' => \App\Http\Middleware\Kyc::class,
        'Ban' => \App\Http\Middleware\Ban::class,
        'Country' => \App\Http\Middleware\Country::class,
        'Email' => \App\Http\Middleware\Email::class,
        'Phone' => \App\Http\Middleware\Phone::class,
        'CheckIfStoreActive' => \App\Http\Middleware\CheckIfStoreActive::class,
        'Compliance' => \App\Http\Middleware\Compliance::class,
        'CheckIfUserhasWebsite' => \App\Http\Middleware\CheckIfUserhasWebsite::class,
        'WebsiteNotAvailble' => \App\Http\Middleware\WebsiteisNotAvailble::class,
        'CheckIfCustomStoreActive' => \App\Http\Middleware\CheckIfCustomStoreActive::class,
        'TerminatedAccounts' => \App\Http\Middleware\TerminatedAccounts::class
    ];
}