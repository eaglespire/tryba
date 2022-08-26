<?php

use App\Http\Controllers\Compliance\ComplianceController;
use Illuminate\Support\Facades\Route;

Route::get('/{url}',[ComplianceController::class , 'getForm'])->name('getComplianceForm');
Route::post('/{url}',[ComplianceController::class , 'RespondForm'])->name('RespondForm');

Route::get('blocked/{url}',[ComplianceController::class , 'getBlockedForm'])->name('getBlockedForm');
Route::post('blocked/{url}',[ComplianceController::class , 'downloadData'])->name('blocked.download');

?>