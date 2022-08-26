<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'ext_transfer',
        'generate_token',
        'initiate_transaction',
        'webhook-sub',
        'compliance-verification/decision',
        'compliance-verification/submits',
        'api/initiate-compliance',
        'address-state',
        'update-cart',
        'getcalendar',
        'modulr-notifications',
        '/api/ivr/*',
        '/api/ivr/menu',
        '/api/ivr/card-operations',
        '/api/ivr/get-phone',
        '/api/ivr/open-account',
        '/api/ivr/verify-phone',
        '/api/ivr/get-pin/{phone}',
        '/api/ivr/verify-pin/{phone}',
        '/api/ivr/other-contact',
        '/api/ivr/send-other-contact-info/',
        '/banking-service/webhook-actions',
        // 'compliance-submitted',
    ];
}
