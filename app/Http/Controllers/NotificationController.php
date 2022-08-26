<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ModulrService;
use App\Models\User;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService) {
        $this->apiKey = \env('MODULR_API_KEY');
        $this->apiSecret = \env('MODULR_API_SECRET');
        $this->url = \env('MODULR_URL');
        $this->notificationService = $notificationService;
    }

}
