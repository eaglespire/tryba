<?php

namespace App\Services;

use App\Services\ModulrServiceAuth;

class NotificationService {

    protected $authService;

    public function __construct(ModulrServiceAuth $authService) {
        $this->authService = $authService;
        $this->apiKey = \env('MODULR_API_KEY');
        $this->apiSecret = \env('MODULR_API_SECRET');
        $this->url = \env('MODULR_URL');
    }

    /**
     * Add webhook notification to customer
    */
    public function add($customerId, $type) {
        $query = \Http::withHeaders($this->authService->getHeaders())->post($this->url."/customers/$customerId/notifications", [
            'type' => \strtoupper($type),
            'channel' => 'WEBHOOK',
            'destinations' => [
                'https://dev.tryba.io/banking-service/webhook-actions'
            ],
            'config' => [
                'timesToRun' => ['AM','PM'],
                'daysToRun' => ['MONDAY','TUESDAY','WEDNESDAY','THURSDAY','FRIDAY'],
                'retry' => true,
                'secret' => hash_hmac('md5', 'TRYBA_SERVICE_LIMITED',$this->apiKey),
                'hmacAlgorithm' => 'hmac-sha256'
            ],
        ]);
        \Log::info("################### Webhook registration ###########");
        \Log::info($query);
        \Log::info("################### Webhook registration ###########");
        if(isset($query['customerId'])) {

        }
        return json_decode($query);
    }


    /**
     * Notification reception
    */
    public function modulrWebhook(Request $request) {
        \Log::info($request->all());
    }
}
