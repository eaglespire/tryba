<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Exttransfer;
use App\Models\Merchant;
use App\Models\User;
use App\Models\Countrysupported;
use App\Models\Currency;
use App\Http\Controllers\Auth\Api\LoginController;
use App\Http\Controllers\Auth\Api\faController;
use App\Http\Controllers\Auth\Api\RegisterController;
use App\Http\Controllers\Api\CastroController;
use App\Http\Controllers\Api\SinglechargeController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\PayoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\WebsiteController;
use App\Http\Controllers\User\StoreController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ShippingController;
use App\Http\Controllers\User\PlanController;
use App\Http\Controllers\Openbanking\TellConnect\TellConnectOperationsController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\IVRController;
use App\Http\Controllers\OpenAccount;
use App\Services\ModulrServiceAuth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('plan', [FrontendController::class, 'getPlans']);
Route::post('login', [LoginController::class, 'submitlogin']);//Login post link
Route::post('waiting-list/add', [WaitingListController::class, 'addEmail']);
Route::post('register', [RegisterController::class, 'submitregister'])->name('submitregister');//Register post link
Route::get('list_supported_countries', [RegisterController::class, 'list_supported_countries']);//List of supported countries
Route::get('list_countries', [RegisterController::class, 'list_countries']);//List of supported countries
Route::get('country', [InvoiceController::class, 'ship_country']);//List of supported countries
Route::get('state/{id}', [InvoiceController::class, 'ship_state']);//List of supported countries
Route::get('supported_countries/{id}', [RegisterController::class, 'supported_countries']);//support country nicename fetching
Route::post('user-password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('generate_token', [CastroController::class, 'generate_token'])->name('generate_token');
Route::post('reset-password', [CastroController::class, 'sendResetLinkEmail']);
Route::post('initiate-compliance', [AccountController::class, 'saveVerifData'])->name('initiate_compliance');
Route::post('get-accessToken', [App\Http\Controllers\SumsubComplianceController::class, 'getToken']);
Route::post('compliance-submitted', [AccountController::class, 'submitVerifData']);
Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's
    //Home
        Route::get('user-plan', [CastroController::class, 'userPlan'])->name('user.email.authorization');
        Route::get('email-authorization', [CastroController::class, 'emailCheck'])->name('user.email.authorization');
        Route::get('phone-authorization', [CastroController::class, 'phoneCheck'])->name('user.phone.authorization');
        Route::post('smsVerify', [CastroController::class, 'smsVerify'])->name('user.sms-verify');
        Route::get('client_billing_plan/{id}', [CastroController::class, 'client_billing_plan']);
        Route::get('client_transactions', [CastroController::class, 'client_transactions']);
        Route::post('initiate_transaction', [CastroController::class, 'initiate_transaction'])->name('submit.pay');
        Route::post('compliance', [CastroController::class, 'compliance']);
        Route::get('client_currency', [CastroController::class, 'client_currency']);
        Route::get('client_country', [CastroController::class, 'client_country']);
        Route::get('verify-payment/{tx_ref}', [CastroController::class, 'verify_payment']);


    //Single Charge
        Route::get('single-gigpot', [SinglechargeController::class, 'sclinks']);
        Route::get('single-gigpot-transactions/{id}', [SinglechargeController::class, 'pottransactions']);
        Route::post('single-pot/deactivate/{id}', [SinglechargeController::class, 'unsclinks']);
        Route::post('single-pot/activate/{id}', [SinglechargeController::class, 'psclinks']);
        Route::put('single-gigpot/update/{id}', [SinglechargeController::class, 'updatesclinks']);
        Route::post('single-gigpot/new', [SinglechargeController::class, 'submitsinglecharge']);
        Route::delete('single-gigpot/delete/{id}', [SinglechargeController::class, 'Destroylink']);
    //End

    //Mutiple gigpot
        Route::get('mutiple-gigpot', [DonationController::class, 'dplinks']);
        Route::get('mutiple-gigpot/{id}', [DonationController::class, 'dplinkstrans']);
        Route::post('mutiple-gigpot/deactivate/{id}', [DonationController::class, 'deactivate']);
        Route::post('mutiple-gigpot/activate/{id}', [DonationController::class, 'activate']);
        Route::put('mutiple-gigpot/update/{id}', [DonationController::class, 'updatedplinks']);
        Route::post('mutiple-gigpot/new', [DonationController::class, 'submitdonationpage']);
        Route::delete('mutiple-gigpot/delete/{id}', [DonationController::class, 'Destroylink']);
        Route::get('mutiple-gigpot/donors/{id}', [DonationController::class, 'donors']);
    //End

    //Invoice
        Route::get('invoice', [InvoiceController::class, 'invoice']);
        Route::get('invoice/{id}', [InvoiceController::class, 'getOneinvoice']);
        Route::post('invoice/new', [InvoiceController::class, 'submitinvoice']);
        Route::put('invoice/update/{id}', [InvoiceController::class, 'Editinvoice']);
        Route::delete('invoice/delete/{id}', [InvoiceController::class, 'Destroyinvoice']);
        Route::get('submit_invoice/{id}', [InvoiceController::class, 'Payinvoice']);
        Route::post('invoice/reminder/{type}/{id}', [InvoiceController::class, 'Reminderinvoice']);
        Route::put('update-customer/{id}', [InvoiceController::class, 'updatecustomer'])->name('update.customer');
        Route::delete('delete-customer/{id}', [InvoiceController::class, 'Destroycustomer'])->name('delete.customer');
        Route::post('add-customer', [InvoiceController::class, 'submitcustomer'])->name('submit.customer');
        Route::get('customer', [InvoiceController::class, 'customer'])->name('user.customer');
    //End

        Route::get('transactions', [CastroController::class, 'transactions']);
        Route::get('transactions/filter/{id}', [CastroController::class, 'filtertransactions']);
        Route::get('logout', [CastroController::class, 'logout'])->name('logout');
        Route::get('credential', [CastroController::class, 'credential'])->name('credential');
        Route::post('social', [CastroController::class, 'social']);
        Route::post('password', [CastroController::class, 'password']);
        Route::post('account', [CastroController::class, 'account']);
        Route::post('preferences', [CastroController::class, 'preferences']);
        Route::post('payment', [CastroController::class, 'payment']);
        Route::get('payment_methods/{user_id}', [CastroController::class, 'payment_methods']);
        Route::get('package', [CastroController::class, 'package']);

        //Expenses
        Route::group(['prefix' => 'expense-manager'], function() {
            Route::get('/total/monthly', [ExpenseController::class, 'getMonthlyTotal']);
            //Category
            Route::get('/category/all', [ExpenseController::class, 'showAllCategory']);
            Route::post('/category/new', [ExpenseController::class, 'addNewCategory']);
            Route::put('/category/{id}', [ExpenseController::class, 'updatePostCategory']);
            Route::delete('/category/{id}', [ExpenseController::class, 'deleteCategory']);
            //Subcatgory
            Route::get("/category/{id}/sub-category/", [ExpenseController::class, 'AllSubCategoryExpenseApi']);
            Route::post("/category/sub-category/new", [ExpenseController::class, 'postSubCategory']);
            Route::put("/category/sub-category/update/{id}", [ExpenseController::class, 'postUpdateSubCategory']);
            Route::delete("/category/sub-category/delete/{id}", [ExpenseController::class, 'deleteSubCategory']);
            //Expenses
            Route::get('/expense', [ExpenseController::class, 'allExpense']);
            Route::post('/expense/new', [ExpenseController::class, 'createExpense']);
            Route::put('/expense/update/{id}', [ExpenseController::class, 'UpdateExpense']);
            Route::delete('/expense/delete/{id}', [ExpenseController::class, 'deleteExpense']);
            //Budget
            Route::get("/budget", [ExpenseController::class, 'allBudget']);
            Route::post("/budget/new", [ExpenseController::class, 'postBudget']);
            Route::put("/budget/update/{id}", [ExpenseController::class, 'putBudget']);
            Route::delete("/budget/delete/{id}", [ExpenseController::class, 'putBudget']);
            //Income
            Route::get("/income", [ExpenseController::class, 'allIncome']);
            Route::post("/income/new", [ExpenseController::class, 'postIncome']);
            Route::put("/income/update/{id}", [ExpenseController::class, 'putIncome']);
            Route::delete("/income/delete/{id}", [ExpenseController::class, 'deleteIncome']);
            //Report
            Route::post("/generate-report", [ExpenseController::class, 'postReport'])->name('postReport');
        });

        Route::group(['prefix' => 'user'], function() {
            Route::get('/{id}', [App\Http\Controllers\BankingController::class, 'findById']);
            Route::get('get-compliance-status/{applicantId}/{uid}', [AccountController::class, 'getVerificationStatus']);
        });


        //Questions
        Route::post('first_question', [OpenAccount::class,'planning_to_tryba']);
        Route::put('second_question', [OpenAccount::class, 'what_would_tryba']);
        Route::put('third_question', [OpenAccount::class, 'gender_and_date']);
        Route::put('fouth_question', [OpenAccount::class, 'describe']);
        Route::put('fifth_question', [OpenAccount::class, 'website']);
        Route::put('sixth_question', [OpenAccount::class, 'turnover']);
        Route::put('seventh_question', [OpenAccount::class, "business"]);
        Route::put("eight_question", [OpenAccount::class, "business_second"]);
        Route::put("personal_info", [OpenAccount::class, "personaldetails"]);
        Route::put("social", [openAccount::class, "sociallinks"]);
});

Route::get('user-details/{merchantkey}', function ($merchantkey) {
    $ref=Merchant::wheremerchant_key($merchantkey)->count();
    if($ref==0){
        return response()->json(['message' => 'Invalid merchant key','status' => 'failed','data' => null], 404);
    }else{
        $merchant=Merchant::wheremerchant_key($merchantkey)->first();
        $user=User::whereId($merchant->user_id)->first();
        return response()->json([
            'message' => 'Api keys',
            'status' => 'success',
            'data' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'public_key' => $user->public_key,
                'secret_key' => $user->secret_key,
            ],
        ], 200);
    }

});
Route::get('currency-supported', function () {
    $country=Countrysupported::wherestatus(1)->get();
    $code=array();
    foreach($country as $val){
        $currency=Currency::whereid($val->coin_id)->first();
        $name=array();
        $code[]=$val->coin_id;
        $name[]=$currency->name;
        $xx =array_push($code, $name);
    }
    return response()->json(['currencies' => $code],
    200);
});
Route::get('currency-supported2', function () {
    $country=Countrysupported::wherestatus(1)->get();
    $code=array();
    $name=array();
    foreach($country as $val){
        $currency=Currency::whereid($val->coin_id)->first();
        $code[]=$val->coin_id;
        $name[]=$currency->name;
    }
    return response()->json(['currency_code' => $code, 'currency_name' => $name],
    200);
});

Route::group(['prefix' => 'banking'], function() {
    Route::post('/create', [App\Http\Controllers\BankingController::class, 'createCustomer']);
    Route::get('{customer_id}', [App\Http\Controllers\BankingController::class, 'getCustomer']);
    Route::get('/{uid}/account', [App\Http\Controllers\BankingController::class, 'getAccount']);
    Route::post('/save-details', [AccountController::class, 'saveAccountData']);
    Route::get('get-institutions/list',        [App\Http\Controllers\BankingController::class, 'getInstitutions']);
    Route::get('/settings/get-key/{id}',        [App\Http\Controllers\BankingController::class, 'createSecureCardDetailsToken']);
    Route::group(['prefix' => 'beneficiary'], function() {
      Route::post('/create', [App\Http\Controllers\BankingController::class, 'createBeneficiary']);
      Route::get('get-list/{cid}/{uid}', [App\Http\Controllers\BankingController::class, 'getBeneficiaries']);
      Route::post('otp',        [App\Http\Controllers\BankingController::class, 'otpVerification']);
      Route::post('verify-payee-account',        [App\Http\Controllers\BankingController::class, 'otpVerification']);
      Route::post('verify-password',        [App\Http\Controllers\BankingController::class, 'passwordVerification']);
      Route::post('verify-payee-account',        [App\Http\Controllers\BankingController::class, 'payeeVerification']);
      Route::get('accounts-list/{cid}',        [App\Http\Controllers\BankingController::class, 'getAccount']);
      Route::get('accounts-list/{id}/all',        [App\Http\Controllers\BankingController::class, 'getAccounts']);
      Route::get('accounts-transactions/{uid}',        [App\Http\Controllers\BankingController::class, 'getTransactions']);
    });
    Route::group(['prefix' => 'cards'], function() {
      Route::post('create', [App\Http\Controllers\BankingController::class, 'createCardAjax']);
      Route::post('physical-card', [App\Http\Controllers\BankingController::class, 'createPhysicalCard']);
      Route::get('{card_id}', [App\Http\Controllers\BankingController::class, 'getCard']);
      Route::get('block-unblock/{card_id}/{action}', [App\Http\Controllers\BankingController::class, 'blockOrUnblock']);
      Route::get('{id}/activate', [App\Http\Controllers\BankingController::class, 'activateCard']);
      Route::get('secure-token/{id}', [App\Http\Controllers\BankingController::class, 'createSecureToken']);
      Route::get('getpin/{id}', [App\Http\Controllers\BankingController::class, 'retrievePin']);
    });
    Route::group(['prefix' => 'payment'], function() {
      Route::post('create', [App\Http\Controllers\BankingController::class, 'createPayment']);
    });
});

Route::group(['prefix' => 'user'], function() {
    Route::get('/{id}', [App\Http\Controllers\BankingController::class, 'findById']);
    Route::get('get-compliance-status/{applicantId}/{uid}', [AccountController::class, 'getVerificationStatus']);
});


// OPEN BANKIMG

Route::group(['prefix' => 'open-banking'], function() {
    Route::post('/create', [App\Http\Controllers\BankingController::class, 'createCustomer']);
    Route::get('{customer_id}', [App\Http\Controllers\BankingController::class, 'getCustomer']);
    Route::get('/{uid}/account', [App\Http\Controllers\BankingController::class, 'getAccount']);
    Route::post('/save-details', [AccountController::class, 'saveAccountData']);
    Route::get('get-institutions/list', [App\Http\Controllers\BankingController::class, 'getInstitutions']);
    //Account Information services
    Route::group(['prefix' => 'accounts'], function() {
        Route::get('/', [App\Http\Controllers\BankingController::class, 'createBeneficiary']);
        Route::get('/{AccountId}', [App\Http\Controllers\BankingController::class, 'getBeneficiaries']);
        Route::get('/{AccountId}/balances',  [App\Http\Controllers\BankingController::class, 'otpVerification']);
        Route::get('/{AccountId}/transactions', [App\Http\Controllers\BankingController::class, 'otpVerification']);

        //TODO
        Route::get('/{AccountId}/beneficiaries', [App\Http\Controllers\BankingController::class, 'otpVerification']);
        Route::get('/{AccountId}/direct-debits', [App\Http\Controllers\BankingController::class, 'otpVerification']);
        Route::get('/{AccountId}/scheduled-payments', [App\Http\Controllers\BankingController::class, 'otpVerification']);
        Route::get('/{AccountId}/standing-orders', [App\Http\Controllers\BankingController::class, 'otpVerification']);
    });

     //Payment Initiation Services
     Route::group(['prefix' => 'pisp'], function() {
        Route::group(['prefix' => 'beneficiary'], function() {
            Route::post('/create', [App\Http\Controllers\BankingController::class, 'createBeneficiary']);
            Route::get('get-list/{cid}/{uid}', [App\Http\Controllers\BankingController::class, 'getBeneficiaries']);
            Route::post('otp',  [App\Http\Controllers\BankingController::class, 'otpVerification']);
            Route::post('verify-payee-account', [App\Http\Controllers\BankingController::class, 'otpVerification']);
            Route::post('verify-password', [App\Http\Controllers\BankingController::class, 'passwordVerification']);
            Route::post('verify-payee-account', [App\Http\Controllers\BankingController::class, 'payeeVerification']);
            Route::get('standing-order-provider-list', [App\Http\Controllers\BankingController::class, 'getPaymentServiceProvider']);
        });
    });

    Route::group(['prefix' => 'cards'], function() {
      Route::post('virtual', [App\Http\Controllers\BankingController::class, 'createCard']);
      Route::post('physical-card', [App\Http\Controllers\BankingController::class, 'createPhysicalCard']);
      Route::get('{card_id}', [App\Http\Controllers\BankingController::class, 'getCard']);
      Route::get('block-unblock/{card_id}/{action}', [App\Http\Controllers\BankingController::class, 'blockOrUnblock']);
      Route::get('{id}/activate', [App\Http\Controllers\BankingController::class, 'activateCard']);
      Route::get('secure-token/{id}', [App\Http\Controllers\BankingController::class, 'createSecureToken']);
      Route::get('getpin/{id}', [App\Http\Controllers\BankingController::class, 'retrievePin']);
    });
    Route::group(['prefix' => 'payment'], function() {
      Route::post('create', [App\Http\Controllers\BankingController::class, 'createPayment']);
    });
});


Route::group(['prefix' => 'compliance-verification'], function () {
    Route::post('verification', [App\Http\Controllers\SumsubComplianceController::class, 'getSumSubAccessToken']);
    Route::get('get-status/{id}', [App\Http\Controllers\SumsubComplianceController::class, 'getApplicantStatus']);
    Route::get('get-applicant-data/{id}', [App\Http\Controllers\SumsubComplianceController::class, 'getApplicantData']);
    Route::get('/company-data', [App\Http\Controllers\SumsubComplianceController::class, 'companyNameCheck']);
    Route::get('/company-data/{regNumber}', [App\Http\Controllers\SumsubComplianceController::class, 'fetchOfficers']);
    Route::get('/company-data/{companyReg}/{etag}/officers', [App\Http\Controllers\SumsubComplianceController::class, 'getBeneficiaries']);
});

// TELL-CONNECT
Route::get('/test-modular', [ModulrServiceAuth::class, 'getHeaders']);

Route::group(['prefix' => 'tell-connect/api'], function() {
    Route::get('/v1', [TellConnectOperationsController::class, 'performTransaction']);
    Route::post('/v1', [TellConnectOperationsController::class, 'performTransaction']);
});


// IVR
Route::group(['prefix' => 'ivr'], function() {

    Route::post('demo', [IVRController::class, 'demo'])->name('ivr.music');

    Route::post('call', [IVRController::class, 'welcome'])->name('ivr.welcome');
    Route::post('menu', [IVRController::class, 'ivrMenu'])->name('ivr.menu');
    Route::post('card-operations', [IVRController::class, 'cardOperations'])->name('ivr.card.operations');
    Route::post('get-phone', [IVRController::class, 'getNumber'])->name('ivr.get.phone');
    Route::post('verify-phone', [IVRController::class, 'verifyNumber'])->name('ivr.verify.phone');
    Route::post('open-account', [IVRController::class, 'openAccount'])->name('ivr.open.account');
    Route::post('get-pin/{phone}', [IVRController::class, 'getPin'])->name('ivr.get.pin');
    Route::post('verify-pin/{phone}', [IVRController::class, 'verifyPin'])->name('ivr.verify.pin');
    Route::post('send-other-contact-info', [IVRController::class, 'otherContact'])->name('ivr.contact.info');
});
