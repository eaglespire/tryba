<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MccController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\Auth\faController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\User\BankController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\StoreController;
use App\Http\Controllers\FundcategoryController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\WebsiteController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BugReportsController;
use App\Http\Controllers\Compliance\ComplianceController;
use App\Http\Controllers\OpenAccount;
use App\Http\Controllers\Store\OfflineController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\User\BookingsController;
use App\Http\Controllers\User\DonationController;
use App\Http\Controllers\User\ShippingController;
use App\Http\Controllers\User\SinglechargeController;
use App\Http\Controllers\User\ResetPasswordController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\Openbanking\TellConnect\TellConnectAuthController;
use App\Http\Controllers\Store\StorefrontController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\WebsiteController as ControllersWebsiteController;
use App\Http\Controllers\newDashborder;
use App\Jobs\EmailVerificationJob;
use App\Mail\EmailVerification;
use App\Models\BankingDetail;
use App\Models\Card;
use App\Models\ComplianceDocument;
use App\Models\Invoice;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\WaitingList;
use App\Services\ModulrService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Http\Controllers\GobalSetting;
use App\Http\Controllers\RequestMoneyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//IPN Link
Route::get('lang/{locale}', [LocalizationController::class, 'index'])->name('lang');
Route::get('ipncoinbase', [PaymentController::class, 'ipnCoinBase'])->name('ipn.coinbase');
Route::get('ipncoinpaybtc', [PaymentController::class, 'ipnCoinPayBtc'])->name('ipn.coinPay.btc');
Route::get('ipncoinpayeth', [PaymentController::class, 'ipnCoinPayEth'])->name('ipn.coinPay.eth');
Route::get('ipnflutter', [PaymentController::class, 'flutterIPN'])->name('ipn.flutter');
Route::get('ipnpaystack', [PaymentController::class, 'paystackIPN'])->name('ipn.paystack');
Route::get('ipnpaypal', [PaymentController::class, 'ipnpaypal'])->name('ipn.paypal');
Route::get('ipnvirtual', [PaymentController::class, 'ipnVirtual'])->name('ipn.virtual');
Route::get('ipnboompay', [PaymentController::class, 'ipnboompay'])->name('ipn.boompay');
Route::get('testcom', [AccountController::class, 'testcom'])->name('testcom');

//Plugins
Route::get('merchant-woo', [WebsiteController::class, 'merchant_woo'])->name('merchant.woo');
Route::get('merchant-gf', [WebsiteController::class, 'merchant_gf'])->name('merchant.gf');
Route::get('merchant-edd', [WebsiteController::class, 'merchant_edd'])->name('merchant.edd');
Route::get('merchant-gwp', [WebsiteController::class, 'merchant_gwp'])->name('merchant.gwp');

//testing Email
// Route::get('/email',function(Request $request){
//     $user = new UserController(new SmsService ,new ModulrService(new Invoice(),new Transactions(), new ComplianceDocument(), new BankingDetail(),new Card(), new User()));
//     $bankDetails = BankingDetail::where('user_id',422)->where('currency','GBP')->first();
//     echo $user->payRequest( $bankDetails,20);
//     // $user = User::find(422);
//     // dispatch_sync(new EmailVerificationJob($user, Str::random(32)));
//     // return new EmailVerification($user, Str::random(32));
// });

Route::get('compliance/{url}', [ComplianceController::class, 'getForm'])->name('getComplianceForm');
Route::post('compliance/{url}', [ComplianceController::class, 'RespondForm'])->name('RespondForm');
Route::post('compliance/{url}', [ComplianceController::class, 'RespondForm'])->name('RespondForm');
Route::get('compliance/blocked/{url}', [ComplianceController::class, 'getBlockedForm'])->name('getBlockedForm');
Route::post('compliance/blocked/{url}', [ComplianceController::class, 'downloadData'])->name('blocked.download');

//callbackss
Route::get('card-callback/{id}', [PaymentController::class, 'cardcallback'])->name('cardcallback');
Route::get('coinbase-success/{id}', [PaymentController::class, 'coinbasesuccess'])->name('coinbasesuccess');
Route::get('coinbase-cancelled/{id}', [PaymentController::class, 'coinbasecancelled'])->name('coinbasecancelled');
Route::get('stripe-success/{id}', [PaymentController::class, 'stripesuccess'])->name('stripesuccess');
Route::get('stripe-cancelled/{id}', [PaymentController::class, 'stripecancelled'])->name('stripecancelled');
Route::get('paypal-success/{id}', [PaymentController::class, 'paypalsuccess'])->name('paypalsuccess');
Route::get('paypal-cancelled/{id}', [PaymentController::class, 'paypalcancelled'])->name('paypalcancelled');
Route::get('generate-receipt/{id}', [UserController::class, 'generatereceipt'])->name('generate.receipt');
Route::get('download-receipt/{id}', [UserController::class, 'downloadreceipt'])->name('download.receipt');
Route::get('complete-order/{store_url}/{id}', [StoreController::class, 'completeOrder'])->name('complete.order');
Route::post('submit-complete-order/{id}', [StoreController::class, 'submitCompleteOrder'])->name('submit.complete.order');
Route::post('authorize-payment/{ref_id}', [PaymentController::class, 'authorize_payment'])->name('authorize.payment');
Route::get('payment-authorization/{id}/{amount}/{bank_id}/{trans_type}', [PaymentController::class, 'createPaymentAuthorization'])->name('auth.payment');
Route::post('user-address-country', [OfflineController::class, 'useraddresscountry'])->name('user.address.country');

//Webhooks
Route::post('webhook-account', [AccountController::class, 'webhook'])->name('accountwebhook');
Route::post('webhook-dispute', [UserController::class, 'webhook'])->name('disputewebhook');
Route::post('webhook-sub', [PaymentController::class, 'webhook'])->name('subwebhook');
Route::get('delcon/{id}', [UserController::class, 'delcon'])->name('delcon');
// Route::get('/dashboard/open-banking',        [App\Http\Controllers\BankingController::class, 'getInstitutions'])->name('open-banking');

//Single Charge
Route::get('process-single-charge/{id}/{token}', [SinglechargeController::class, 'process_single_charge'])->name('process.single.charge');
Route::get('pot/{id}', [SinglechargeController::class, 'gigpotLink'])->name('pot.link');
Route::get('pot-test', [FrontendController::class, 'index'])->name('pot.test');
Route::get('request-money/{slug}', [RequestMoneyController::class, 'requestLink'])->name('requestMoney');
Route::post('request-money/{slug}', [RequestMoneyController::class, 'intiateRequestPayment'])->name('pay.request.link');

//Yapily
Route::get('getYapilyInstitution',[PaymentController::class,'getYapilyInstitution'])->name('get.yapilyInstution');
Route::get('apple-single-charge/{id}', [SinglechargeController::class, 'applescviewlink'])->name('apple.scview.link');
Route::get('card-single-charge/{id}', [SinglechargeController::class, 'cardscviewlink'])->name('card.scview.link');
Route::get('payment-method-single-charge/{id}/{method}', [SinglechargeController::class, 'pmsinglecharge'])->name('pmsinglecharge');
Route::get('stripe-single-charge/{id}', [SinglechargeController::class, 'stripescviewlink'])->name('stripe.scview.link');
Route::post('pay-single', [SinglechargeController::class, 'Sendsingle'])->name('send.single');
Route::get('checkout/open-banking/{ref_id}',[PaymentController::class,'getTransactionToPay'])->name('get.getTransactionToPay');
Route::get('checkout/transaction/{ref_id}',[PaymentController::class,'getTransactionTopayData'])->name('get.getTransactionTopayData');

//Market
Route::get('market', [MarketController::class, 'market'])->name('market');
Route::get('market/{cat}', [MarketController::class, 'marketcat'])->name('market.cat');
Route::get('market/country/{id}', [MarketController::class, 'marketcountry'])->name('market.country');
Route::post('market/search-market', [MarketController::class, 'searchmarket'])->name('search.market');
//Store
Route::middleware(['WebsiteNotAvailble'])->group(function () {
    Route::group(['prefix' => 'website',], function () {
        Route::get('{id}', [OfflineController::class, 'storelink'])->name('website.link');
        Route::get('{id}/about', [OfflineController::class, 'about'])->name('website.about');
        Route::get('{id}/services', [OfflineController::class, 'services'])->name('website.services');
        Route::get('{id}/services/{service}', [OfflineController::class, 'singleService'])->name('single.service');
        Route::get('{id}/blogs', [OfflineController::class, 'blog'])->name('website.blogs');
        Route::get('{id}/contact', [OfflineController::class, 'contact'])->name('website.contact');
        Route::post('{id}/contact', [OfflineController::class, 'sendResponse'])->name('website.contact');
        Route::post('{id}/working-hours', [OfflineController::class, 'getWorkingHours'])->name('website.getworkingHours');
        Route::post('{id}/cart/{service}', [OfflineController::class, 'addToCart'])->name('website.addtoCart');
        Route::delete('{id}/cart/{service}', [OfflineController::class, 'removeService'])->name('remove.item.cart');
        Route::get('{id}/cart', [OfflineController::class, 'showCart'])->name('website.getCart');
        Route::get('{id}/articles/all', [OfflineController::class, 'storeArticles'])->name('store.blog.index');
        Route::get('{id}/team/all', [OfflineController::class, 'storeTeam'])->name('store.team.index');
        Route::get('{id}/review/all', [OfflineController::class, 'storeReview'])->name('store.review.index');
        Route::get('{id}/faq/all', [OfflineController::class, 'storeFaq'])->name('store.faq.index');
        Route::post('{id}/getcalendar', [StoreController::class, 'getCalendar'])->name('store.calender');
        Route::post('{id}/getavailabletime', [StoreController::class, 'getAvailableTime'])->name('store.availabletime');
        Route::get('{id}/articles/category/{title}/{cat_id}', [OfflineController::class, 'storeArticles'])->name('store.blog.cat.index');
        Route::get('{id}/blog/{ref}/{slug}', [OfflineController::class, 'storeBlogView'])->name('store.blog.view');
        Route::get('{id}/page/{ref}/{slug}', [OfflineController::class, 'storePageView'])->name('store.page.view');
        Route::get('category/{id}/{cat}/{slug?}', [OfflineController::class, 'storecat'])->name('store.cat');
        Route::post('booking/checkout', [OfflineController::class, 'checkbooking'])->name('check.booking');
        Route::post('checkoutcoupon/{id}', [OfflineController::class, 'checkcoupon'])->name('check.coupon');
        Route::post('bookcoupon/{id}', [OfflineController::class, 'bookcoupon'])->name('book.coupon');
        Route::get('customer-password/reset/{store_url}', [ForgotPasswordController::class, 'customershowLinkRequestForm'])->name('customer.password.request');
        Route::post('customer-password/email', [ForgotPasswordController::class, 'customersendResetLinkEmail'])->name('customer.password.email');
        Route::get('customer-password/reset/{token}/{store_url}', [ResetPasswordController::class, 'customershowResetForm'])->name('customer.password.reset');
        Route::post('customer-password/reset', [ResetPasswordController::class, 'customerreset']);
        Route::group(['prefix' => 'customer',], function () {
            Route::post('login', [OfflineController::class, 'submitcustomerlogin'])->name('submitcustomerlogin');
            Route::get('{store_url}/login', [OfflineController::class, 'customerlogin'])->name('customer.login');
            Route::get('{store_url}/receipt/{id}', [UserController::class, 'generatereceipt'])->name('website.receipt');
            Route::post('register', [OfflineController::class, 'submitcustomerregister'])->name('submitcustomerregister');
            Route::get('{store_url}/register', [OfflineController::class, 'customerregister'])->name('customer.register');
            Route::get('{store_url}option', [OfflineController::class, 'customeroption'])->name('customer.option');
            Route::post('address-state', [OfflineController::class, 'customeraddressstate'])->name('customer.address.state');
            Route::post('user-address-state', [OfflineController::class, 'useraddressstate'])->name('user.address.state');
            Route::post('ffff-user-address-state', [OfflineController::class, 'useraddressstatef'])->name('user.address.statef');
            Route::post('ffff-user-address-country', [OfflineController::class, 'useraddresscountryf'])->name('user.address.countryf');
            Route::post('customer-update-cart', [OfflineController::class, 'updatecheckout'])->name('customer.update.cart');
            Route::get('{store_url}/emtpy-cart/{id}', [OfflineController::class, 'emptycart'])->name('customer.empty.cart');
            Route::group(['middleware' => 'auth:customer'], function () {
                Route::get('{store_url}/bookings', [OfflineController::class, 'customerbookings'])->name('customer.bookings');
                Route::get('{store_url}/account', [OfflineController::class, 'customeraccount'])->name('customer.account');
                Route::post('{store_url}/account-update', [OfflineController::class, 'customeraccountupdate'])->name('customer.account.update');
                Route::post('{store_url}/product-review', [OfflineController::class, 'productreview'])->name('product.review');
                Route::post('{store_url}/booking-review', [OfflineController::class, 'bookingreview'])->name('booking.review');
                Route::get('{store_url}/security', [OfflineController::class, 'customersecurity'])->name('customer.security');
                Route::post('{store_url}/security-update', [OfflineController::class, 'customersecurityupdate'])->name('customer.security.update');
                Route::get('{store_url}order/{id}', [OfflineController::class, 'customerorderstatus'])->name('customer.order.status');
                Route::get('{store_url}booking/{id}', [OfflineController::class, 'customerbookingstatus'])->name('customer.booking.status');
                Route::get('{store_url}/address', [OfflineController::class, 'customeraddress'])->name('customer.address');
                Route::get('{store_url}/address-add', [OfflineController::class, 'customeraddressadd'])->name('customer.address.add');
                Route::post('{store_url}/address-save', [OfflineController::class, 'customeraddresssave'])->name('customer.address.save');
                Route::get('{store_url}/address-edit/{id}', [OfflineController::class, 'customeraddressedit'])->name('customer.address.edit');
                Route::get('{store_url}/address-delete/{id}', [OfflineController::class, 'customeraddressdelete'])->name('customer.address.delete');
                Route::post('{store_url}/address-update', [OfflineController::class, 'customeraddressupdate'])->name('customer.address.update');
                Route::get('{store_url}/logout', [OfflineController::class, 'logout'])->name('customer.logout');
            });
        });
    });
});

//store routes
Route::middleware(['CheckIfStoreActive'])->group(function () {
    Route::group(['prefix' => 'store',], function () {
        Route::get('{id}', [StorefrontController::class, 'storefront'])->name('store.index');
        Route::get('{id}/product/{product}', [StorefrontController::class, 'productlink'])->name('sproduct.link');
        Route::post('{id}/search', [StorefrontController::class, 'searchstorelink'])->name('search.website.link');
        Route::get('{id}/register', [StorefrontController::class, 'customerregister'])->name('store.customer.register');
        Route::get('{id}/login', [StorefrontController::class, 'customerlogin'])->name('store.customer.login');
        Route::post('{id}/login', [StorefrontController::class, 'submitcustomerlogin'])->name('store.submitcustomerlogin');
        Route::get('{id}/track-order', [StorefrontController::class, 'trackorder'])->name('track.order');
        Route::post('{id}/order-details', [StorefrontController::class, 'submittrackorder'])->name('submittrackorder');
        Route::get('{id}/products', [OfflineController::class, 'storeProducts'])->name('store.products.index');
        Route::post('products/checkout', [OfflineController::class, 'checkproduct'])->name('check.product');
        Route::get('delete/cart/{id}', [OfflineController::class, 'deletecart'])->name('delete.cart');
        Route::post('{id}/update-cart', [StorefrontController::class, 'updatecart'])->name('update.cart');
        Route::get('{id}/cart/{cartid}/{coupon?}', [StorefrontController::class, 'sask'])->name('user.sask');
        Route::group(['middleware' => 'auth:customer'], function () {
            Route::get('{id}/wishlist-add/{wishlistId}', [StorefrontController::class, 'customerwishlistadd'])->name('customer.wishlist.add');
            Route::get('{id}/wishlist', [StorefrontController::class, 'customerwishlist'])->name('store.customer.wishlist');
            Route::get('{id}/delete/wishlist/{wishlistId}', [StorefrontController::class, 'deletewishlist'])->name('delete.wishlist');
            Route::get('{id}/order', [StorefrontController::class, 'customerorder'])->name('store.customer.order');
            Route::get('{store_url}/bookings', [StorefrontController::class, 'customerbookings'])->name('customer.bookings');
            Route::get('{id}/account', [StorefrontController::class, 'customeraccount'])->name('store.customer.account');
            Route::post('{id}/account-update', [OfflineController::class, 'customeraccountupdate'])->name('store.customer.account.update');
            Route::post('{store_url}/product-review', [OfflineController::class, 'productreview'])->name('product.review');
            Route::get('{id}/security', [StorefrontController::class, 'customersecurity'])->name('store.customer.security');
            Route::post('{id}/security-update', [OfflineController::class, 'customersecurityupdate'])->name('store.customer.security.update');
            Route::get('{store_url}order/{id}', [OfflineController::class, 'customerorderstatus'])->name('customer.order.status');
            Route::get('{id}/address', [StorefrontController::class, 'customeraddress'])->name('store.customer.address');
            Route::get('{id}/address-add', [StorefrontController::class, 'customeraddressadd'])->name('store.customer.address.add');
            Route::post('{id}/address-save', [StorefrontController::class, 'customeraddresssave'])->name('store.customer.address.save');
            Route::get('{id}/address-edit/{addressid}', [OfflineController::class, 'customeraddressedit'])->name('store.customer.address.edit');
            Route::get('{id}/address-delete/{addressid}', [OfflineController::class, 'customeraddressdelete'])->name('store.customer.address.delete');
            Route::post('{id}/address-update', [OfflineController::class, 'customeraddressupdate'])->name('store.customer.address.update');
            Route::get('{id}/logout', [StorefrontController::class, 'logout'])->name('store.customer.logout');
        });
    });
});

//Donation
Route::post('pay-donation', [DonationController::class, 'Senddonation'])->name('send.donation');
Route::get('donation/{id}', [DonationController::class, 'dpviewlink'])->name('dpview.link');
Route::get('card-donation-charge/{id}', [DonationController::class, 'carddpviewlink'])->name('card.dpview.link');
Route::get('account-donation-charge/{id}', [DonationController::class, 'accountdpviewlink'])->name('account.dpview.link');
Route::get('stripe-donation-charge/{id}', [DonationController::class, 'stripedpviewlink'])->name('stripe.dpview.link');


//Invoicest
Route::get('invoice/{id}', [InvoiceController::class, 'Viewinvoice'])->name('view.invoice');
Route::get('stripe-invoice/{id}/{ref_id}', [InvoiceController::class, 'stripeViewinvoice'])->name('stripe.view.invoice');
Route::post('pay-invoice', [InvoiceController::class, 'Processinvoice'])->name('process.invoice');
Route::get('payment-method-invoice/{id}/{method}', [InvoiceController::class, 'pminvoice'])->name('pminvoice');
Route::get('download-invoice/{id}', [InvoiceController::class, 'downloadinvoice'])->name('download.invoice');

//Website
Route::get('xpay/{id}/{xx}', [WebsiteController::class, 'transferprocess'])->name('transfer.process');
Route::get('stripe_xpay/{id}/{xx}', [WebsiteController::class, 'stripetransferprocess'])->name('stripe.transfer.process');
Route::post('submit_merchant', [WebsiteController::class, 'Paymerchant'])->name('pay.merchant');
Route::post('ext_transfer', [WebsiteController::class, 'submitpay'])->name('submit.pay');


//Product
Route::post('buyproduct', [ProductController::class, 'acquireproduct'])->name('pay.product');
Route::get('stripe-buyproduct/{id}', [ProductController::class, 'stripeacquireproduct'])->name('stripe.pay.product');
Route::get('payment-method-product/{id}/{method}', [ProductController::class, 'pmproduct'])->name('pmproduct');

//Error Route
Route::get('error', [WebsiteController::class, 'transfererror'])->name('transfererror');


Route::get('contact', [UserController::class, 'contact'])->name('contact');
Route::get('faq', [UserController::class, 'faq'])->name('faq')->middleware(['throttle:global']);

// Front end routes
Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('pricing', [FrontendController::class, 'pricing'])->name('pricing');
Route::get('support', [FrontendController::class, 'support'])->name('support');
Route::get('features', [FrontendController::class, 'features'])->name('features');
Route::get('about', [FrontendController::class, 'about'])->name('about');
Route::get('blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('terms', [FrontendController::class, 'terms'])->name('terms');
Route::get('modulr-terms', [FrontendController::class, 'modulrterms'])->name('modulr.terms');
Route::get('privacy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('page/{id}', [FrontendController::class, 'page']);
Route::get('single/{id}/{slug}', [FrontendController::class, 'article']);
Route::get('cat/{id}/{slug}', [FrontendController::class, 'category']);
Route::get('contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('contact', [FrontendController::class, 'contactSubmit'])->name('contact-submit');
Route::post('about', [FrontendController::class, 'subscribe'])->name('subscribe');
Route::get('/download-statement',        [App\Http\Controllers\BankingController::class, 'generateStatement']);
Route::get('/transaction-invoice/{id}',        [App\Http\Controllers\BankingController::class, 'generateTransactionStatement'])->name('transaction.invoice.download');
Route::post('/open-banking',        [App\Http\Controllers\BankingController::class, 'getInstitutions'])->name('payment.open-banking');
// Route::group(['prefix' => 'banking'], function() {
//     return "BAnking";
// });
// User routes
Auth::routes();

Route::post('login', [LoginController::class, 'submitlogin'])->name('submitlogin');
Route::get('login', [LoginController::class, 'redirectHome'])->name('login');
Route::post('2fa', [faController::class, 'submitfa'])->name('submitfa');
Route::get('2fa', [faController::class, 'faverify'])->name('2fa');
Route::post('register', [RegisterController::class, 'submitregister'])->name('submitregister');
Route::post('pre-register', [RegisterController::class, 'preregister'])->name('preregister');
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::get('business-register', [RegisterController::class, 'businessregister'])->name('business.register');
Route::get('/forget', [UserController::class, 'forget'])->name('forget');
Route::get('/r_pass', [UserController::class, 'r_pass'])->name('r_pass');
Route::group(['prefix' => 'user',], function () {
    Route::get('blocked', [UserController::class, 'terminated'])->name('user.blocked');
    Route::middleware(['TerminatedAccounts'])->group(function () {
        Route::put('update-user-mcc/{id}', [UserController::class, 'updateProfile'])->name('user.mcc.update');
        Route::get('suspended', [UserController::class, 'blocked'])->name('user.suspend');
        Route::get('phone-authorization', [UserController::class, 'phoneCheck'])->name('user.phone.authorization');
        Route::get('edit-mobile', [UserController::class, 'editphone'])->name('user.editphone');
        Route::post('update-mobile', [UserController::class, 'updatephone'])->name('user.updatephone');
        Route::get('verification', [UserController::class, 'sendVcode'])->name('user.send-vcode');
        Route::get('authorization', [UserController::class, 'authCheck'])->name('user.authorization');
        Route::post('smsVerify', [UserController::class, 'smsVerify'])->name('user.sms-verify');
        Route::get('verify-sms', [UserController::class, 'sendSmsVcode'])->name('user.send-smsVcode');
        Route::post('buy-email-limits/{id}', [UserController::class, 'buyEmail'])->name('user.buyEmail');
        Route::post('buy-sms-limits/{id}', [UserController::class, 'buySMS'])->name('user.smsEmail');
        Route::get('customer-verify-email/{id}', [StoreController::class, 'confirmEmailVcode'])->name('customer.confirm-emailVcode');
        Route::post('send-bug-report', [BugReportsController::class, 'postProblem'])->name('send.bug');
        Route::group(['middleware' => 'auth:user'], function () {
            Route::group(['prefix' => 'email',], function () {
                Route::post('send-email', [UserController::class, 'sendEmail'])->name('user.send-email');
                Route::get('confirm-email/{id}', [UserController::class, 'confirmEmail'])->name('user.confirm-email');
                Route::get('verify-email', [UserController::class, 'verifyEmail'])->name('user.verify-email');
            });
            Route::get('compliance-session', [AccountController::class, 'compliancesession'])->name('compliance.session');
            Route::post('country', [AccountController::class, 'submitcountry'])->name('submit.country');
            Route::middleware(['Ban', 'Blocked', 'Email', 'Phone', 'Tfa'])->group(function () {
                Route::post('generate-request-link', [RequestMoneyController::class, 'createRequestLink'])->name('user.generate.link');
                Route::post('send-request-link/{slug}', [RequestMoneyController::class, 'sendRequestLink'])->name('user.send.request.link');
                Route::post('send-request-link/whatsapp/{slug}', [RequestMoneyController::class, 'sendWhatsappLink'])->name('user.send.request.link');
                Route::put('planning_to_tryba', [OpenAccount::class, 'planning_to_tryba'])->name('planning_to_tryba');
                Route::put('what_would_tryba', [OpenAccount::class, 'what_would_tryba'])->name('what_would_tryba');
                Route::put('gender_and_date', [OpenAccount::class, 'gender_and_date'])->name('gender_and_date');
                Route::put('describe', [OpenAccount::class, 'describe'])->name('describe');
                Route::put('website', [OpenAccount::class, 'website'])->name('opening_website');
                Route::put('turnover', [OpenAccount::class, 'turnover'])->name('turnover_monthly');
                Route::put('business-information', [OpenAccount::class, "business"])->name('business_info');
                Route::put("business_second", [OpenAccount::class, "business_second"])->name('business_second');
                Route::put("personal_info", [OpenAccount::class, "personaldetails"])->name('personal_info');
                Route::get('beneficary/{id}', [UserController::class, 'getbeneficary']);
                Route::post('card', [UserController::class, 'card'])->name('card');
                Route::get('stripe_card/{id}', [UserController::class, 'stripecard'])->name('stripe.card');
                Route::get('compliance-refresh', [UserController::class, 'comrefresh'])->name('compliance.refresh');
                Route::get('compliance-return', [UserController::class, 'comreturn'])->name('compliance.return');
                Route::get('upgrade-account', [AccountController::class, 'upgradeaccount'])->name('upgrade.account');
                Route::get('downgrade-account', [AccountController::class, 'downgradeaccount'])->name('downgrade.account');
                Route::post('upgrade-submit', [AccountController::class, 'upgradesubmit'])->name('upgrade.submit');
                Route::post('flutter', [UserController::class, 'newflutter'])->name('flutter');
                Route::post('search', [UserController::class, 'search'])->name('search');
                Route::get('others', [UserController::class, 'dashboard'])->name('others');
                Route::get('dashboard/old', [UserController::class, 'dashboard'])->name('user.dashboard.old');
                Route::get('dashboard', [UserController::class, 'newdashboard'])->name('user.dashboard');

                Route::get('single-charge', [UserController::class, 'transactions'])->name('user.transactionssc');
                Route::get('transactions', [UserController::class, 'transactions'])->name('user.transactions');
                Route::post('sort/transactions', [UserController::class, 'sorttransactions'])->name('user.transactions.sort');
                Route::post('sort/archive-transactions', [UserController::class, 'sortarchivetransactions'])->name('user.archive.transactions.sort');
                Route::post('sort/sclinks/transactions', [SinglechargeController::class, 'sorttransactions'])->name('user.transactions.sort.sclinks');
                Route::post('sort/sclinks/archive-transactions', [SinglechargeController::class, 'sortarchivetransactions'])->name('user.archive.transactions.sort.sclinks');
                Route::get('transactions-archive', [UserController::class, 'transactionsarchive'])->name('user.transactions.archive');
                Route::post('archive-transactions', [UserController::class, 'archivetransactions'])->name('user.archive.transactions');
                Route::post('rarchive-transactions', [UserController::class, 'rarchivetransactions'])->name('user.rarchive.transactions');
                Route::get('my-sub', [UserController::class, 'yoursub'])->name('user.mysub');
                Route::get('chargebacks', [UserController::class, 'chargeback'])->name('user.chargeback');
                Route::get('charges', [UserController::class, 'charges'])->name('user.charges');
                Route::get('/business/{company}', [UserController::class, "company_reg_no"])->name('business_company');
                Route::get('/stripe-payment', [UserController::class, "stripe_connect"])->name('stripe');
                Route::get("/postal/{search_term}", [UserController::class, 'postcode']);
                Route::get('profile', [AccountController::class, 'profile'])->name('user.profile');
                Route::get('preferences', [AccountController::class, 'showpreferences'])->name('user.preferences');
                Route::get('/open-banking/user-consents', [AccountController::class, 'getUserPermissions'])->name('openbanking.permissions');
                Route::get('/open-banking/user-consents/revoke/{id}', [AccountController::class, 'revokeUserPermissions'])->name('openbanking.permissions.revoke');
                Route::post('/create-card', 'App\Http\Controllers\BankingController@createCard')->name('user.card.create');

                Route::get('rex', [UserController::class, 'rex'])->name('user.rex');
                Route::get('account-mode{id}', [AccountController::class, 'accountmode'])->name('user.account.mode');
                Route::get('security', [AccountController::class, 'showSecurity'])->name('user.security');
                Route::get('social', [AccountController::class, 'showSocial'])->name('user.social');
                Route::get('api', [AccountController::class, 'showApi'])->name('user.api');
                Route::get('compliance', [AccountController::class, 'no_kyc'])->name('user.compliance');
                Route::get('generate-api', [AccountController::class, 'generateapi'])->name('generateapi');
                Route::post('save-webhook', [AccountController::class, 'savewebhook'])->name('savewebhook');
                Route::post('kyc', [AccountController::class, 'kyc']);
                Route::post('account', [AccountController::class, 'account'])->name('user.profile.update');
                Route::post('preferences', [AccountController::class, 'preferences'])->name('user.preferences.update');
                Route::post('payment', [AccountController::class, 'payment'])->name('user.payment.update');
                Route::post('social', [AccountController::class, 'social'])->name('user.social');
                Route::post('avatar', [AccountController::class, 'avatar']);
                Route::post('delaccount', [UserController::class, 'delaccount'])->name('delaccount');

                Route::middleware(['Compliance'])->group(function () {
                    //Products
                    Route::post('add-product', [ProductController::class, 'submitproduct'])->name('submit.product');
                    Route::post('add-category', [ProductController::class, 'submitcategory'])->name('submit.category');
                    Route::get('edit-product/{id}', [ProductController::class, 'Editproduct'])->name('edit.product');
                    Route::get('orders/{id}', [ProductController::class, 'orders'])->name('orders');
                    Route::post('description_update', [ProductController::class, 'Descriptionupdate'])->name('product.description.submit');
                    Route::post('feature_update', [ProductController::class, 'Featureupdate'])->name('product.feature.submit');
                    Route::post('add-product-image', [ProductController::class, 'submitproductimage'])->name('submit.product.image');
                    Route::get('delete-product-image/{id}', [ProductController::class, 'deleteproductimage'])->name('delete.product.image');
                    Route::get('delete-category/{id}', [ProductController::class, 'Destroyproductcategory'])->name('delete.category');
                    Route::get('delete-product/{id}', [ProductController::class, 'Destroyproduct'])->name('delete.product');

                    Route::group(['prefix' => 'website'], function () {
                        Route::get('create', [ControllersWebsiteController::class, 'createWebsite'])->name('new.website');
                        Route::post('create', [ControllersWebsiteController::class, 'submitWebsite'])->name('post.website');
                        Route::post('check-website', [ControllersWebsiteController::class, 'checkWebsiteUrl'])->name('check.storeURL');
                        Route::middleware(['CheckIfUserhasWebsite'])->group(function () {
                            Route::get('settings', [ControllersWebsiteController::class, 'settings'])->name('website.settings');
                            Route::put('update', [ControllersWebsiteController::class, 'postWebsite'])->name('website.update');
                            Route::put('booking-configuration', [ControllersWebsiteController::class, 'bookingApp'])->name('booking.configuration');
                            Route::get('widget', [ControllersWebsiteController::class, 'widgets'])->name('website.widgets');
                            Route::group(['prefix' => 'widget'], function () {
                                Route::post('menu', [ControllersWebsiteController::class, 'widgetsMenu'])->name('website.widgets.menu');
                                Route::group(['prefix' => 'slider'], function () {
                                    Route::get('add', [ControllersWebsiteController::class, 'addSlider'])->name('add.slider.website');
                                    Route::get('edit/{id}', [ControllersWebsiteController::class, 'editSlider'])->name('edit.slider.website');
                                    Route::post('create', [ControllersWebsiteController::class, 'createSlider'])->name('create.slider.website');
                                    Route::post('update/{id}', [ControllersWebsiteController::class, 'updateSlider'])->name('update.slider.website');
                                    Route::delete('delete/{id}', [ControllersWebsiteController::class, 'deleteSlider'])->name('delete.slider.website');
                                });
                            });
                            Route::get('themes', [ControllersWebsiteController::class, 'websiteThemes'])->name('website.theme');
                            Route::get('default-theme/{themeId}', [ControllersWebsiteController::class, 'defaultTheme'])->name('default.website.theme');
                            Route::group(['prefix' => 'appointment'], function () {
                                Route::get('/', [ControllersWebsiteController::class, 'appointment'])->name('user.appointment');
                                Route::get('/pending', [ControllersWebsiteController::class, 'pending'])->name('user.appointment.pending');
                                Route::get('/completed', [ControllersWebsiteController::class, 'completed'])->name('user.appointment.completed');
                                Route::get('/reschedule/{id}', [StoreController::class, 'reschedule'])->name('user.appointment.reschedule');
                                Route::post('/update/reschedule/{id}', [StoreController::class, 'updateschedule'])->name('update.schedule');
                                Route::get('services', [ControllersWebsiteController::class, 'services'])->name('user.services');
                                Route::post('edit', [StoreController::class, 'editbooking'])->name('edit.booking');
                                Route::group(['prefix' => 'service'], function () {
                                    Route::get('add', [BookingsController::class, 'add'])->name('new.service');
                                    Route::post('add', [BookingsController::class, 'create'])->name('create.service');
                                    Route::get('update/{id}', [BookingsController::class, 'edit'])->name('getUpdate.service');
                                    Route::put('update/{id}', [BookingsController::class, 'putService'])->name('put.service');
                                    Route::get('delete/{id}', [BookingsController::class, 'delete'])->name('delete.service');
                                });
                            });
                            Route::group(['prefix' => 'team'], function () {
                                Route::get('add', [ControllersWebsiteController::class, 'addTeam'])->name('add.team.website');
                                Route::get('edit/{id}', [ControllersWebsiteController::class, 'editTeam'])->name('edit.team.website');
                                Route::post('create/{id}', [ControllersWebsiteController::class, 'createTeam'])->name('create.team.website');
                                Route::post('update/{id}', [ControllersWebsiteController::class, 'updateTeam'])->name('update.team.website');
                                Route::get('delete/{id}', [ControllersWebsiteController::class, 'deleteTeam'])->name('delete.team.website');
                            });
                        });

                        Route::group(['prefix' => 'mail'], function () {
                            Route::post('edit/{id}', [StoreController::class, 'editmail'])->name('edit.store.mail');
                            Route::post('test', [StoreController::class, 'sendEmail'])->name('test.store.mail');
                            Route::post('send/{id}', [StoreController::class, 'sendEmail'])->name('send.store.mail');
                        });

                        Route::group(['prefix' => 'coupon'], function () {
                            Route::post('add', [ShippingController::class, 'submitCoupon'])->name('submit.coupon');
                            Route::post('edit/{id}', [ShippingController::class, 'editCoupon'])->name('edit.coupon');
                            Route::get('update/{id}', [ShippingController::class, 'updateCoupon'])->name('update.coupon');
                            Route::get('delete/{id}', [ShippingController::class, 'destroyCoupon'])->name('delete.coupon');
                        });

                        Route::group(['prefix' => 'customer'], function () {
                            Route::get('/', [StoreController::class, 'customers'])->name('website.customer');
                            Route::get('orders/{id}', [StoreController::class, 'customerorders'])->name('customer.orders');
                            Route::get('sendemail/{id}', [StoreController::class, 'customersendemail'])->name('customer.send.email');
                        });

                        Route::post('edit-domain/{id}', [StoreController::class, 'editdomain'])->name('edit.domain');
                        Route::post('disconnect-domain/{id}', [StoreController::class, 'disConnect'])->name('disconnect.domain');
                        Route::get('storefront/create', [StoreController::class, 'createStore'])->name('new.createStore');
                        Route::post('edit-website', [StoreController::class, 'editwebsite'])->name('edit.website');
                        Route::get('coupon', [StoreController::class, 'websiteCoupon'])->name('website.coupon');
                        Route::get('blog', [StoreController::class, 'websiteBlog'])->name('website.blog');
                        Route::get('faq', [StoreController::class, 'websiteFaq'])->name('website.faq');
                        Route::get('brand', [StoreController::class, 'websiteBrand'])->name('website.brand');
                        Route::get('review', [StoreController::class, 'websiteReview'])->name('website.review');
                        Route::get('team', [StoreController::class, 'websiteTeam'])->name('website.team');
                        Route::get('pages', [StoreController::class, 'websitePage'])->name('website.page');
                        Route::get('custom_domain', [StoreController::class, 'websiteInstruction'])->name('user.store.custom.domain');
                        Route::post('verify_custom_domain', [StoreController::class, 'verifyDns'])->name('user.store.custom.domain.verify');
                        Route::post('add-store', [StoreController::class, 'submitstore'])->name('submit.website');
                        Route::post('check-business', [StoreController::class, 'checkBusiness'])->name('business.check');
                    });
                    //Store
                    Route::get('customize-storefront', [StoreController::class, 'storefront'])->name('user.storefront.customize');
                    Route::get('your-list', [StoreController::class, 'storefront'])->name('user.your-list');
                    Route::get('store-list/{id}', [StoreController::class, 'storeorders'])->name('store.your-list');
                    Route::post('store-list-status/{id}', [StoreController::class, 'orderstatus'])->name('store.order.status');
                    Route::get('default-theme/{id}/{key}', [StoreController::class, 'defaultTheme'])->name('default.store');
                    Route::group(['prefix' => 'storefront'], function () {
                        Route::get('settings', [StoreController::class, 'storefront'])->name('user.storefront');
                        Route::get('themes', [StoreController::class, 'storefrontThemes'])->name('user.storefront.themes');
                        Route::get('dashboard', [StoreController::class, 'ecommerce'])->name('user.ecommerce');
                        Route::get('orders', [StoreController::class, 'ecommerce'])->name('user.list');
                        Route::get('shipping', [StoreController::class, 'ecommerce'])->name('user.shipping');
                        Route::get('product', [StoreController::class, 'ecommerce'])->name('user.product');
                        Route::post('edit', [StoreController::class, 'editstore'])->name('edit.store');
                        Route::get('new-product', [StoreController::class, 'newproduct'])->name('new.product');
                        Route::group(['prefix' => 'product'], function () {
                        });
                        Route::group(['prefix' => 'shipping'], function () {
                            Route::post('add', [ShippingController::class, 'submitShipping'])->name('submit.shipping');
                            Route::post('edit', [ShippingController::class, 'editShipping'])->name('edit.shipping');
                            Route::get('delete/{id}', [ShippingController::class, 'destroyShipping'])->name('delete.shipping');
                        });
                        Route::group(['prefix' => 'slider'], function () {
                            Route::get('add', [ThemeController::class, 'addSlider'])->name('add.slider.store');
                            Route::get('edit/{id}', [ThemeController::class, 'editSlider'])->name('edit.slider.store');
                            Route::post('create/{id}', [ThemeController::class, 'createSlider'])->name('create.slider.store');
                            Route::post('update/{id}', [ThemeController::class, 'updateSlider'])->name('update.slider.store');
                            Route::get('delete/{id}', [ThemeController::class, 'deleteSlider'])->name('delete.slider.store');
                        });
                    });


                    //Theme
                    Route::group(['prefix' => 'theme'], function () {
                        Route::group(['prefix' => 'feature'], function () {
                            Route::get('add', [ThemeController::class, 'addFeature'])->name('add.feature.store');
                            Route::get('edit/{id}', [ThemeController::class, 'editFeature'])->name('edit.feature.store');
                            Route::post('create/{id}', [ThemeController::class, 'createFeature'])->name('create.feature.store');
                            Route::post('update/{id}', [ThemeController::class, 'updateFeature'])->name('update.feature.store');
                            Route::get('delete', [ThemeController::class, 'deleteFeature'])->name('delete.feature.store');
                        });
                        Route::group(['prefix' => 'pages'], function () {
                            Route::get('add', [ThemeController::class, 'addPage'])->name('add.page.store');
                            Route::get('edit/{id}', [ThemeController::class, 'editPage'])->name('edit.page.store');
                            Route::post('create/{id}', [ThemeController::class, 'createPage'])->name('create.page.store');
                            Route::post('update/{id}', [ThemeController::class, 'updatePage'])->name('update.page.store');
                            Route::get('delete/{id}', [ThemeController::class, 'deletePage'])->name('delete.page.store');
                        });
                        Route::group(['prefix' => 'brand'], function () {
                            Route::get('add', [ThemeController::class, 'addBrand'])->name('add.brand.store');
                            Route::get('edit/{id}', [ThemeController::class, 'editBrand'])->name('edit.brand.store');
                            Route::post('create/{id}', [ThemeController::class, 'createBrand'])->name('create.brand.store');
                            Route::post('update/{id}', [ThemeController::class, 'updateBrand'])->name('update.brand.store');
                            Route::get('delete/{id}', [ThemeController::class, 'deleteBrand'])->name('delete.brand.store');
                        });
                        Route::group(['prefix' => 'review'], function () {
                            Route::get('add', [ThemeController::class, 'addReview'])->name('add.review.store');
                            Route::get('edit/{id}', [ThemeController::class, 'editReview'])->name('edit.review.store');
                            Route::post('create/{id}', [ThemeController::class, 'createReview'])->name('create.review.store');
                            Route::post('update/{id}', [ThemeController::class, 'updateReview'])->name('update.review.store');
                            Route::get('delete/{id}', [ThemeController::class, 'deleteReview'])->name('delete.review.store');
                        });

                        Route::group(['prefix' => 'blog'], function () {
                            Route::get('add', [ThemeController::class, 'addBlog'])->name('add.blog.store');
                            Route::get('edit/{id}', [ThemeController::class, 'editBlog'])->name('edit.blog.store');
                            Route::post('create/{id}', [ThemeController::class, 'createBlog'])->name('create.blog.store');
                            Route::post('update/{id}', [ThemeController::class, 'updateBlog'])->name('update.blog.store');
                            Route::get('delete/{id}', [ThemeController::class, 'deleteBlog'])->name('delete.blog.store');
                            Route::group(['prefix' => 'category'], function () {
                                Route::get('index', [StoreController::class, 'websiteBlog'])->name('customer.blog.cat');
                                Route::get('add', [ThemeController::class, 'addBlogCat'])->name('add.blog.cat.store');
                                Route::get('edit/{id}', [ThemeController::class, 'editBlogCat'])->name('edit.blog.cat.store');
                                Route::post('create/{id}', [ThemeController::class, 'createBlogCat'])->name('create.blog.cat.store');
                                Route::post('update/{id}', [ThemeController::class, 'updateBlogCat'])->name('update.blog.cat.store');
                                Route::get('delete/{id}', [ThemeController::class, 'deleteBlogCat'])->name('delete.blog.cat.store');
                            });
                        });
                        Route::group(['prefix' => 'faq'], function () {
                            Route::get('add', [ThemeController::class, 'addFaq'])->name('add.faq.store');
                            Route::get('edit/{id}', [ThemeController::class, 'editFaq'])->name('edit.faq.store');
                            Route::post('create/{id}', [ThemeController::class, 'createFaq'])->name('create.faq.store');
                            Route::post('update/{id}', [ThemeController::class, 'updateFaq'])->name('update.faq.store');
                            Route::get('delete/{id}', [ThemeController::class, 'deleteFaq'])->name('delete.faq.store');
                            Route::group(['prefix' => 'category'], function () {
                                Route::get('index', [StoreController::class, 'websiteFaq'])->name('customer.faq.cat');
                                Route::get('add', [ThemeController::class, 'addFaqCat'])->name('add.faq.cat.store');
                                Route::get('edit/{id}', [ThemeController::class, 'editFaqCat'])->name('edit.faq.cat.store');
                                Route::post('create/{id}', [ThemeController::class, 'createFaqCat'])->name('create.faq.cat.store');
                                Route::post('update/{id}', [ThemeController::class, 'updateFaqCat'])->name('update.faq.cat.store');
                                Route::get('delete/{id}', [ThemeController::class, 'deleteFaqCat'])->name('delete.faq.cat.store');
                            });
                        });
                        Route::group(['prefix' => 'text'], function () {
                            Route::post('update/{id}', [ThemeController::class, 'updateText'])->name('update.slider.text');
                        });
                        Route::get('edit', [ThemeController::class, 'edit'])->name('theme.edit.store');
                        Route::get('import/demo/{id}', [ThemeController::class, 'importDemo'])->name('theme.import.demo');
                        Route::get('slider', [ThemeController::class, 'edit'])->name('theme.slider.store');
                        Route::get('review', [ThemeController::class, 'edit'])->name('theme.review.store');
                        Route::get('features', [ThemeController::class, 'edit'])->name('theme.features.store');
                        Route::get('menu', [ThemeController::class, 'edit'])->name('theme.menu.store');
                        Route::post('update-menu/{id}', [ThemeController::class, 'menuUpdate'])->name('theme.menu.store.update');
                        Route::get('brands', [ThemeController::class, 'edit'])->name('theme.brands.store');
                    });

                    //Merchant
                    Route::get('merchant', [WebsiteController::class, 'merchant'])->name('user.merchant');
                    Route::get('sender_log', [WebsiteController::class, 'senderlog'])->name('user.senderlog');
                    Route::get('merchant-documentation', [WebsiteController::class, 'merchant_documentation'])->name('user.merchant-documentation');
                    Route::get('merchant-button', [WebsiteController::class, 'merchant'])->name('user.merchant-button');
                    Route::get('merchant-plugin', [WebsiteController::class, 'merchant'])->name('user.merchant-plugin');
                    Route::get('merchant-html', [WebsiteController::class, 'merchant'])->name('user.merchant-html');
                    Route::get('merchant-api', [WebsiteController::class, 'merchant'])->name('user.merchant-api');
                    Route::post('add-merchant', [WebsiteController::class, 'submitmerchant'])->name('submit.merchant');
                    Route::get('log-merchant/{id}', [WebsiteController::class, 'Logmerchant'])->name('log.merchant');
                    Route::get('delete-merchant/{id}', [WebsiteController::class, 'Destroymerchant'])->name('delete.merchant');
                    Route::get('cancel_payment/{id}', [WebsiteController::class, 'Cancelpayment'])->name('cancel.payment');
                    Route::get('cancel_merchant/{id}', [WebsiteController::class, 'Cancelmerchant'])->name('cancel.merchant');
                    Route::post('editmerchant', [WebsiteController::class, 'updatemerchant'])->name('update.merchant');

                    //End
                    //Invoice
                    Route::post('sort/invoice', [InvoiceController::class, 'sortinvoice'])->name('user.invoice.sort');
                    Route::get('invoice', [InvoiceController::class, 'invoice'])->name('user.invoice');
                    Route::get('customer', [InvoiceController::class, 'invoice'])->name('user.customer');
                    Route::put('editcustomer/{refid}', [InvoiceController::class, 'updatecustomer'])->name('update.customer');
                    Route::get('add-customer', [InvoiceController::class, 'addcustomer'])->name('user.add-customer');
                    Route::post('add-customer', [InvoiceController::class, 'submitcustomer'])->name('submit.customer');
                    Route::get('edit-customer/{id}', [InvoiceController::class, 'Editcustomer'])->name('edit.customer');
                    Route::get('delete-customer/{id}', [InvoiceController::class, 'Destroycustomer'])->name('delete.customer');
                    Route::get('preview-invoice/{id}', [InvoiceController::class, 'previewinvoice'])->name('preview.invoice');
                    Route::get('add-invoice', [InvoiceController::class, 'addinvoice'])->name('user.add-invoice');
                    Route::post('add-invoice', [InvoiceController::class, 'submitinvoice'])->name('submit.invoice');
                    Route::post('add-preview', [InvoiceController::class, 'submitpreview'])->name('submit.preview');
                    Route::get('edit-invoice/{id}', [InvoiceController::class, 'Editinvoice'])->name('edit.invoice');
                    Route::get('delete-invoice/{id}', [InvoiceController::class, 'Destroyinvoice'])->name('delete.invoice');
                    Route::get('submit_invoice/{id}', [InvoiceController::class, 'Payinvoice'])->name('pay.invoice');
                    Route::get('reminder/{id}', [InvoiceController::class, 'Reminderinvoice'])->name('reminder.invoice');
                    Route::get('sms-invoice/{id}', [InvoiceController::class, 'smsinvoice'])->name('sms.invoice');
                    Route::get('paid/{id}', [InvoiceController::class, 'Paidinvoice'])->name('paid.invoice');
                    Route::put('editinvoice', [InvoiceController::class, 'updateinvoice'])->name('update.invoice');
                    //End

                    //Bank
                    Route::get('connections', [AccountController::class, 'showConnection'])->name('user.bank');
                    Route::get('connections/xero/connect', [AccountController::class, 'connectXero'])->name('user.xero');
                    Route::get('connections/xero/disconnect', [AccountController::class, 'disconnectXero'])->name('user.xero.disconnect');

                    //PayPAl Service
                    Route::get('paypal/connect', [AccountController::class, 'GetPayPalLInk'])->name('payPalLInk');
                    Route::get('paypal', [AccountController::class, 'redirectUrl'])->name('redirectUrl');
                    Route::get('/paypal/disconnect', [AccountController::class, 'disconnectPayPal'])->name('disconnectPayPal');
                    Route::post('paypal/confirm', [AccountController::class, 'returnUrlPayPal'])->name('payPalSave');

                    //Bank Services
                    Route::get('banking-services', [BankController::class, 'index'])->name('user.banking');
                    Route::get('banking-kyc', [BankController::class, 'kyc'])->name('user.banking.kyc');

                    //Single Charge
                    Route::post('sort/gigpot', [SinglechargeController::class, 'sortsclinks'])->name('user.sclinks.sort');
                    Route::get('gigpot', [SinglechargeController::class, 'sclinks'])->name('user.sclinks');
                    Route::get('gigpot/transactions/{id}', [SinglechargeController::class, 'sclinkstrans'])->name('user.sclinkstrans');
                    Route::get('gigpot/contributors/{id}', [SinglechargeController::class, 'sclinkscontributors'])->name('user.sclinkscontributors');
                    Route::get('archive/gigpot/{id}', [SinglechargeController::class, 'archivesclinkstrans'])->name('user.sclinkstrans.archive');
                    Route::get('gigpot/deactivate/{id}', [SinglechargeController::class, 'unsclinks'])->name('sclinks.unpublish');
                    Route::get('gigpot/activate/{id}', [SinglechargeController::class, 'psclinks'])->name('sclinks.publish');
                    Route::post('gigpot/edit', [SinglechargeController::class, 'updatesclinks'])->name('update.sclinks');
                    Route::post('single-charge', [SinglechargeController::class, 'submitsinglecharge'])->name('submit.singlecharge');
                    Route::get('gigpot/delete/{id}', [SinglechargeController::class, 'Destroylink'])->name('delete.user.sclink');
                    //End

                    //Donation
                    Route::get('multiple-gigpot', [DonationController::class, 'dplinks'])->name('user.dplinks');
                    Route::get('multiple-gigpot/transactions/{id}', [DonationController::class, 'dplinkstrans'])->name('user.dplinkstrans');
                    Route::get('multiple-gigpot/deactivate/{id}', [DonationController::class, 'undplinks'])->name('dplinks.unpublish');
                    Route::get('multiple-gigpot/activate/{id}', [DonationController::class, 'pdplinks'])->name('dplinks.publish');
                    Route::post('multiple-gigpot/edit', [DonationController::class, 'updatedplinks'])->name('update.dplinks');
                    Route::post('donation_page', [DonationController::class, 'submitdonationpage'])->name('submit.donationpage');
                    Route::get('multiple-gigpot/delete/{id}', [DonationController::class, 'Destroylink'])->name('delete.user.dplink');
                    Route::post('donation', [DonationController::class, 'submitdonation'])->name('submit.donation');
                    //End

                    //Plans
                    Route::get('package', [UserController::class, 'package'])->name('user.package');
                    Route::get('billing', [AccountController::class, 'showBilling'])->name('user.billing');
                    Route::get('cancel-package', [UserController::class, 'cancelpackage'])->name('user.cancel.package');
                    Route::post('preview-buy', [UserController::class, 'check_plan'])->name('user.check_plan');

                    //Dipsute
                    Route::get('ticket', [UserController::class, 'ticket'])->name('user.ticket');
                    Route::get('disputes', [UserController::class, 'dispute'])->name('user.dispute');
                    Route::get('open-ticket', [UserController::class, 'openticket'])->name('open.ticket');
                    Route::post('submit-ticket', [UserController::class, 'submitticket'])->name('submit-ticket');
                    Route::get('ticket/delete/{id}', [UserController::class, 'Destroyticket'])->name('ticket.delete');
                    Route::get('reply-ticket/{id}', [UserController::class, 'Replyticket'])->name('ticket.reply');
                    Route::post('reply-ticket', [UserController::class, 'submitreply']);
                    Route::get('resolve-ticket/{id}', [UserController::class, 'Resolveticket'])->name('ticket.resolve');
                    //End

                    //Expense
                    Route::group(['prefix' => 'expense-manager'], function () {
                        Route::get('/expense', [ExpenseController::class, 'allExpense'])->name('allExpense');
                        Route::get('/dashboard', [ExpenseController::class, 'dashboard'])->name('expense.dashboard');
                        Route::get('/expense/new', [ExpenseController::class, 'show'])->name('show.expense');
                        Route::post('/expense/new', [ExpenseController::class, 'createExpense'])->name('create.expense');
                        Route::get('/expense/update/{id}', [ExpenseController::class, 'showUpdateExpense'])->name('show.update.expense');
                        Route::put('/expense/update/{id}', [ExpenseController::class, 'UpdateExpense'])->name('update.expense');
                        Route::delete('/expense/delete/{id}', [ExpenseController::class, 'showDeleteExpense'])->name('delete.expense');
                        Route::get('/category', [ExpenseController::class, 'showAllCategory'])->name('AllCategoryExpense');
                        Route::get('/category/new', [ExpenseController::class, 'showCategory'])->name('show.CategoryExpense');
                        Route::post('/category/new', [ExpenseController::class, 'postCategory'])->name('post.CategoryExpense');
                        Route::get('/category/update/{id}', [ExpenseController::class, 'updateCategory'])->name('update.CategoryExpense');
                        Route::put('/category/update/{id}', [ExpenseController::class, 'updatePostCategory'])->name('update.post.CategoryExpense');
                        Route::delete('/category/delete/{id}', [ExpenseController::class, 'deleteCategory'])->name('delete.CategoryExpense');
                        Route::get("/budget", [ExpenseController::class, 'allBudget'])->name('allBudget');
                        Route::get("/budget/new", [ExpenseController::class, 'newBudget'])->name('newBudget');
                        Route::post("/budget/new", [ExpenseController::class, 'postBudget'])->name('postBudget');
                        Route::get("/budget/update/{id}", [ExpenseController::class, 'updateBudget'])->name('updateBudget');
                        Route::put("/budget/update/{id}", [ExpenseController::class, 'putBudget'])->name('putBudget');
                        Route::delete("/budget/delete/{id}", [ExpenseController::class, 'deleteBudget'])->name('deleteBudget');
                        Route::get("/category/{id}/sub-category", [ExpenseController::class, 'AllSubCategoryExpense'])->name('AllSubCategoryExpense');
                        Route::post("/category/api/sub-category", [ExpenseController::class, 'AllSubCategoryExpenseApi'])->name('AllSubCategoryExpenseApi');
                        Route::get("/category/sub-category/new", [ExpenseController::class, 'showCreateSubCategory'])->name('showCreateSubCategory');
                        Route::post("/category/sub-category/new", [ExpenseController::class, 'postSubCategory'])->name('postSubCategory');
                        Route::get("/category/sub-category/update/{id}", [ExpenseController::class, 'showUpdateSubCategory'])->name('showUpdateSubCategory');
                        Route::put("/category/sub-category/update/{id}", [ExpenseController::class, 'postUpdateSubCategory'])->name('postUpdateSubCategory');
                        Route::delete("/category/sub-category/delete/{id}", [ExpenseController::class, 'deleteSubCategory'])->name('deleteSubCategory');
                        Route::get("/income", [IncomeController::class, 'allIncome'])->name('allIncome');
                        Route::get("/income/new", [IncomeController::class, 'showAddIncome'])->name('showAddIncome');
                        Route::post("/income/new", [IncomeController::class, 'postIncome'])->name('postIncome');
                        Route::get("/income/update/{id}", [IncomeController::class, 'showputIncome'])->name('showputIncome');
                        Route::put("/income/update/{id}", [IncomeController::class, 'putIncome'])->name('putIncome');
                        Route::delete("/income/delete/{id}", [IncomeController::class, 'deleteIncome'])->name('deleteIncome');
                        Route::get("/generate-report", [IncomeController::class, 'showreport'])->name('showreport');
                        Route::post("/generate-report", [IncomeController::class, 'postReport'])->name('postReport');
                    });



                    Route::post('password', [AccountController::class, 'submitPassword'])->name('change.password');
                    Route::get('deposit-confirm', [PaymentController::class, 'depositConfirm'])->name('deposit.confirm');
                    Route::post('2fa', [AccountController::class, 'submit2fa'])->name('change.2fa');
                });
            });
        });
    });
    Route::get('logout', [AccountController::class, 'logout'])->name('user.logout');
});

//global setting stephen
Route::group(['prefix' => 'global'], function () {
    Route::get("/setting", [GobalSetting::class, 'index']);
    Route::get("/apiKeys&webhooks", [GobalSetting::class, 'APIKeyWeb']);
    Route::get("/preference", [GobalSetting::class, 'preferglobal']);
    Route::get("/security", [GobalSetting::class, 'security']);
    Route::get("/Connections", [GobalSetting::class, 'Connections']);
});

Route::get('user-password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('user.password.request');
Route::post('user-password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('user.password.email');
Route::get('user-password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('user.password.reset');
Route::post('user-password/reset', [ResetPasswordController::class, 'reset']);

Route::get('bank-callback', [PaymentController::class, 'bankcallback'])->name('bankcallback');
Route::get('bank-recall/{id}', [PaymentController::class, 'bankrecall'])->name('bankrecall');


//ADMIN ROUTES

Route::get('vx', [AdminController::class, 'adminlogin'])->name('admin.loginForm');
Route::post('vx', [AdminController::class, 'submitadminlogin'])->name('admin.login');



Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/logout', [CheckController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [CheckController::class, 'dashboard'])->name('admin.dashboard');
    //Blog controller
    Route::post('/createcategory', [PostController::class, 'CreateCategory']);
    Route::post('/updatecategory', [PostController::class, 'UpdateCategory']);
    Route::get('/post-category', [PostController::class, 'category'])->name('admin.cat');
    Route::get('/unblog/{id}', [PostController::class, 'unblog'])->name('blog.unpublish');
    Route::get('/pblog/{id}', [PostController::class, 'pblog'])->name('blog.publish');
    Route::get('blog', [PostController::class, 'index'])->name('admin.blog');
    Route::get('blog/create', [PostController::class, 'create'])->name('blog.create');
    Route::post('blog/create', [PostController::class, 'store'])->name('blog.store');
    Route::get('blog/delete/{id}', [PostController::class, 'destroy'])->name('blog.delete');
    Route::get('category/delete/{id}', [PostController::class, 'delcategory'])->name('blog.delcategory');
    Route::get('blog/edit/{id}', [PostController::class, 'edit'])->name('blog.edit');
    Route::post('blog-update', [PostController::class, 'updatePost'])->name('blog.update');

    //Country Controller
    Route::get('admin-downgrade-account/{id}', [CheckController::class, 'admindowngradeaccount'])->name('admin.downgrade.account');
    Route::post('/createcountry', [CountryController::class, 'CreateCountry']);
    Route::post('country/update', [CountryController::class, 'UpdateCountry'])->name('country.update');
    Route::post('country-transfer/update', [CountryController::class, 'UpdateCountrytransfer'])->name('country.transfer.update');
    Route::get('country/delete/{id}', [CountryController::class, 'DestroyCountry'])->name('country.delete');
    Route::get('country-transfer/delete/{id}', [CountryController::class, 'DestroyCountrytransfer'])->name('country.transfer.delete');
    Route::get('country', [CountryController::class, 'country'])->name('admin.country');
    Route::get('clbank/{id}', [CountryController::class, 'clbank'])->name('admin.clbank');
    Route::get('clbankacct/{id}', [CountryController::class, 'clbankacct'])->name('admin.clbankacct');
    Route::get('country/users/{id}', [CountryController::class, 'cusers'])->name('admin.cusers');
    Route::get('country/features/{id}', [CountryController::class, 'cfeatures'])->name('admin.cfeatures');
    Route::get('country/transfer/{id}', [CountryController::class, 'ctransfer'])->name('admin.ctransfer');
    Route::get('country/crypto/{id}', [CountryController::class, 'ccrypto'])->name('admin.crypto');
    Route::post('createclbank', [CountryController::class, 'Createclbank'])->name('admin.createclbank');
    Route::post('clbank-update', [CountryController::class, 'Updateclbank'])->name('clbank.update');
    Route::get('/uncoin/{id}', [CountryController::class, 'uncountry'])->name('country.unpublish');
    Route::get('/pcoin/{id}', [CountryController::class, 'pcountry'])->name('country.publish');
    Route::post('country-features', [CountryController::class, 'features'])->name('admin.country.features.update');
    Route::post('country-crypto', [CountryController::class, 'crypto'])->name('admin.country.crypto.update');
    Route::post('country-transfer', [CountryController::class, 'transfer'])->name('admin.country.transfer.update');
    Route::post('country-new-transfer', [CountryController::class, 'newtransfer'])->name('admin.country.transfer.list.new');
    Route::post('createlbank', [CountryController::class, 'Createlbank'])->name('admin.createlbank');
    Route::post('lbank/update', [CountryController::class, 'Updatelbank'])->name('lbank.update');
    Route::get('lbank/delete/{id}', [CountryController::class, 'Destroylbank'])->name('lbank.delete');
    Route::get('lbank', [CountryController::class, 'lbank'])->name('admin.lbank');
    //End of Country Controller

    //Bug Report
    Route::get('bug-reports', [BugReportsController::class, 'getBugs'])->name('admin.getBugs');

    //Web controller
    Route::post('social-links/update', [WebController::class, 'UpdateSocial'])->name('social-links.update');
    Route::get('social-links', [WebController::class, 'sociallinks'])->name('social-links');

    Route::post('about-us/update', [WebController::class, 'UpdateAbout'])->name('about-us.update');
    Route::get('about-us', [WebController::class, 'aboutus'])->name('about-us');

    Route::post('privacy-policy/update', [WebController::class, 'UpdatePrivacy'])->name('privacy-policy.update');
    Route::get('privacy-policy', [WebController::class, 'privacypolicy'])->name('privacy-policy');

    Route::post('terms/update', [WebController::class, 'UpdateTerms'])->name('terms.update');
    Route::get('terms', [WebController::class, 'terms'])->name('admin.terms');

    Route::post('/createfaq', [WebController::class, 'CreateFaq']);
    Route::post('faq/update', [WebController::class, 'UpdateFaq'])->name('faq.update');
    Route::get('faq/delete/{id}', [WebController::class, 'DestroyFaq'])->name('faq.delete');
    Route::get('faq', [WebController::class, 'faq'])->name('admin.faq');

    Route::post('create/service', [WebController::class, 'CreateService']);
    Route::post('service/update', [WebController::class, 'UpdateService'])->name('service.update');
    Route::get('service/edit/{id}', [WebController::class, 'EditService'])->name('brand.edit');
    Route::get('service/delete/{id}', [WebController::class, 'DestroyService'])->name('service.delete');
    Route::get('service', [WebController::class, 'services'])->name('admin.service');

    Route::post('/create/page', [WebController::class, 'CreatePage']);
    Route::post('page/update', [WebController::class, 'UpdatePage'])->name('page.update');
    Route::get('page/delete/{id}', [WebController::class, 'DestroyPage'])->name('page.delete');
    Route::get('page', [WebController::class, 'page'])->name('admin.page');
    Route::get('/unpage/{id}', [WebController::class, 'unpage'])->name('page.unpublish');
    Route::get('/ppage/{id}', [WebController::class, 'ppage'])->name('page.publish');

    //Get Blocked Account
    Route::get('/blocked-accounts', [CheckController::class, 'blockedUsers'])->name('admin.blocked.user');
    if (env('APP_ENV') == 'local') {
        Route::get('/blocked-accounts/{slug}', [CheckController::class, 'UnblockedUsers'])->name('admin.unblocked.user');
    }
    Route::get('/email-and-sms-pricing', [WebController::class, 'emailandsmspicing'])->name('admin.email.pricing');
    Route::post('/email-and-sms-pricing', [WebController::class, 'savePricing'])->name('admin.save.pricing');
    Route::post('/create/review', [WebController::class, 'CreateReview']);
    Route::post('review/update', [WebController::class, 'UpdateReview'])->name('review.update');
    Route::get('review/edit/{id}', [WebController::class, 'EditReview'])->name('review.edit');
    Route::get('review/delete/{id}', [WebController::class, 'DestroyReview'])->name('review.delete');
    Route::get('review', [WebController::class, 'review'])->name('admin.review');
    Route::get('/unreview/{id}', [WebController::class, 'unreview'])->name('review.unpublish');
    Route::get('/preview/{id}', [WebController::class, 'preview'])->name('review.publish');

    Route::post('/createbrand', [WebController::class, 'CreateBrand']);
    Route::post('brand/update', [WebController::class, 'UpdateBrand'])->name('brand.update');
    Route::get('brand/edit/{id}', [WebController::class, 'EditBrand'])->name('brand.edit');
    Route::get('brand/delete/{id}', [WebController::class, 'DestroyBrand'])->name('brand.delete');
    Route::get('brand', [WebController::class, 'brand'])->name('admin.brand');
    Route::get('/unbrand/{id}', [WebController::class, 'unbrand'])->name('brand.unpublish');
    Route::get('/pbrand/{id}', [WebController::class, 'pbrand'])->name('brand.publish');

    Route::post('createbranch', [WebController::class, 'CreateBranch']);
    Route::post('branch/update', [WebController::class, 'UpdateBranch'])->name('branch.update');
    Route::get('branch/delete/{id}', [WebController::class, 'DestroyBranch'])->name('branch.delete');
    Route::get('branch', [WebController::class, 'branch'])->name('admin.branch');

    Route::get('currency', [WebController::class, 'currency'])->name('admin.currency');
    Route::get('pcurrency/{id}', [WebController::class, 'pcurrency'])->name('change.currency');

    Route::get('logo', [WebController::class, 'logo'])->name('admin.logo');
    Route::post('light-logo', [WebController::class, 'light'])->name('light.logo');
    Route::post('dark-logo', [WebController::class, 'dark'])->name('dark.logo');
    Route::post('updatefavicon', [WebController::class, 'UpdateFavicon']);

    Route::get('home-page', [WebController::class, 'homepage'])->name('homepage');
    Route::post('home-page/update', [WebController::class, 'Updatehomepage'])->name('homepage.update');
    Route::post('section1/update', [WebController::class, 'section1']);
    Route::post('section2/update', [WebController::class, 'section2']);
    Route::post('section3/update', [WebController::class, 'section3']);
    Route::post('section7/update', [WebController::class, 'section7']);
    Route::post('settlement', [SettingController::class, 'SettlementUpdate'])->name('admin.settlement.update');

    //Withdrawal controller
    Route::get('withdraw-log', [WithdrawController::class, 'log'])->name('admin.withdraw.log');
    Route::get('withdraw/delete/{id}', [WithdrawController::class, 'delete'])->name('withdraw.delete');
    Route::get('approvewithdraw/{id}', [WithdrawController::class, 'approve'])->name('withdraw.approve');
    Route::post('declinewithdraw', [WithdrawController::class, 'decline'])->name('withdraw.decline');

    //themes
    Route::get('themes/website', [ThemeController::class, 'getAllTheme'])->name('admin.website.themes');
    Route::get('themes/website/add', [ThemeController::class, 'showCreate'])->name('admin.website.theme.create');
    Route::post('themes/website/add', [ThemeController::class, 'addTheme'])->name('create.webiste.theme');
    Route::put('themes/website/update/{id}', [ThemeController::class, 'updateTheme'])->name('update.website.theme');

    //Deposit controller
    Route::get('bank-transfer', [DepositController::class, 'banktransfer'])->name('admin.banktransfer');
    Route::get('bank_transfer/delete/{id}', [DepositController::class, 'DestroyTransfer'])->name('banktransfer.delete');
    Route::post('bankdetails', [DepositController::class, 'bankdetails']);
    Route::get('deposit-log', [DepositController::class, 'depositlog'])->name('admin.deposit.log');
    Route::get('deposit-method', [DepositController::class, 'depositmethod'])->name('admin.deposit.method');
    Route::post('storegateway', [DepositController::class, 'store']);
    Route::get('approvebk/{id}', [DepositController::class, 'approvebk'])->name('deposit.approvebk');
    Route::get('declinebk/{id}', [DepositController::class, 'declinebk'])->name('deposit.declinebk');
    Route::get('deposit/delete/{id}', [DepositController::class, 'DestroyDeposit'])->name('deposit.delete');
    Route::get('approvedeposit/{id}', [DepositController::class, 'approve'])->name('deposit.approve');
    Route::get('declinedeposit/{id}', [DepositController::class, 'decline'])->name('deposit.decline');

    //Setting controller
    Route::get('settings', [SettingController::class, 'Settings'])->name('admin.setting');
    Route::post('settings', [SettingController::class, 'SettingsUpdate'])->name('admin.settings.update');
    Route::post('charges', [SettingController::class, 'charges'])->name('admin.charges.update');
    Route::post('features', [SettingController::class, 'features'])->name('admin.features.update');
    Route::post('crypto', [SettingController::class, 'crypto'])->name('admin.crypto.update');
    Route::post('account', [SettingController::class, 'AccountUpdate'])->name('admin.account.update');
    Route::post('savings', [SettingController::class, 'SavingsUpdate'])->name('admin.savings.update');
    Route::get('charges', [TransferController::class, 'charges'])->name('admin.charges');
    Route::get('sc-links', [TransferController::class, 'sclinks'])->name('admin.sclinks');
    Route::get('dp-links', [TransferController::class, 'dplinks'])->name('admin.dplinks');
    Route::get('delete-link/{id}', [TransferController::class, 'Destroylink'])->name('delete.link');
    Route::get('unlinks/{id}', [TransferController::class, 'unlinks'])->name('links.unpublish');
    Route::get('plinks/{id}', [TransferController::class, 'plinks'])->name('links.publish');
    Route::get('links/{id}', [TransferController::class, 'linkstrans'])->name('admin.linkstrans');


    Route::get('single-charge', [TransferController::class, 'transactions'])->name('admin.transactionssc');
    Route::get('donation', [TransferController::class, 'transactions'])->name('admin.transactionsd');
    Route::get('invoice-log', [TransferController::class, 'transactions'])->name('admin.invoicelog');
    Route::get('cdeposit-log', [TransferController::class, 'transactions'])->name('admin.cdepositlog');
    Route::get('transactions', [TransferController::class, 'transactions'])->name('admin.transactions');
    Route::get('my-sub', [TransferController::class, 'transactions'])->name('admin.mysub');
    Route::get('sender_log', [TransferController::class, 'transactions'])->name('admin.senderlog');

    //Transfer controller
    Route::get('transfer', [TransferController::class, 'Ownbank'])->name('admin.ownbank');
    Route::get('transfer/delete/{id}', [TransferController::class, 'Destroyownbank'])->name('transfer.delete');

    //Request Money controller
    Route::get('request', [TransferController::class, 'Requestmoney'])->name('admin.request');
    Route::get('request/delete/{id}', [TransferController::class, 'Destroyrequest'])->name('request.delete');

    //Saving controller
    Route::get('saving', [TransferController::class, 'saving'])->name('admin.saving');

    //Invoice controller
    Route::get('invoice', [TransferController::class, 'invoice'])->name('admin.invoice');
    Route::get('invoice/delete/{id}', [TransferController::class, 'Destroyinvoice'])->name('invoice.delete');

    //Admin
    Route::get('refund-merchant/{id}', [TransferController::class, 'refundmerchant'])->name('admin.merchant.refund');
    Route::get('refund-inlinks/{id}', [TransferController::class, 'refundinlinks'])->name('admin.inlinks.refund');
    Route::get('refund-sclinks/{id}', [TransferController::class, 'refundsclinks'])->name('admin.sclinks.refund');
    Route::get('refund-dplinks/{id}', [TransferController::class, 'refunddplinks'])->name('admin.dplinks.refund');

    //Product
    Route::get('product', [TransferController::class, 'product'])->name('admin.product');
    Route::get('product/delete/{id}', [TransferController::class, 'Destroyproduct'])->name('product.delete');
    Route::get('unproduct/{id}', [TransferController::class, 'unproduct'])->name('product.unpublish');
    Route::get('product/{id}', [TransferController::class, 'pproduct'])->name('product.publish');
    Route::get('orders/{id}', [TransferController::class, 'orders'])->name('admin.orders');

    //Investment controller
    Route::get('py-plans/{id}', [CountryController::class, 'Plans'])->name('admin.py.plans');
    Route::get('py-plan/delete/{id}', [CountryController::class, 'PlanDestroy'])->name('py.plan.delete');
    Route::get('py-plan-create/{id}', [CountryController::class, 'Create'])->name('admin.plan.create');
    Route::post('py-plan-create', [CountryController::class, 'Store'])->name('admin.plan.store');
    Route::post('py-plan-edit', [CountryController::class, 'Update'])->name('admin.plan.update');
    Route::get('py-plan/{id}', [CountryController::class, 'Edit'])->name('admin.plan.edit');

    Route::get('plan', [TransferController::class, 'plans'])->name('admin.plan');
    Route::get('plan-sub/{id}', [TransferController::class, 'plansub'])->name('admin.plansub');
    Route::get('unplan/{id}', [TransferController::class, 'unplan'])->name('plan.unpublish');
    Route::get('pplan/{id}', [TransferController::class, 'pplan'])->name('plan.publish');

    //User controller
    Route::get('staff', [CheckController::class, 'Staffs'])->name('admin.staffs');
    Route::get('new-staff', [CheckController::class, 'Newstaff'])->name('new.staff');
    Route::post('new-staff', [CheckController::class, 'Createstaff'])->name('create.staff');
    Route::get('users', [CheckController::class, 'Users'])->name('admin.users');
    Route::get('messages', [CheckController::class, 'Messages'])->name('admin.message');
    Route::get('unblock-staff/{id}', [CheckController::class, 'Unblockstaff'])->name('staff.unblock');
    Route::get('block-staff/{id}', [CheckController::class, 'Blockstaff'])->name('staff.block');
    Route::get('reject-user/{id}', [CheckController::class, 'Rejectuser'])->name('user.reject');
    Route::get('activate-user/{id}', [CheckController::class, 'Unblockuser'])->name('user.unblock');
    Route::get('compliance', [CheckController::class, 'compliance'])->name('user.compliance');
    Route::get('compliance/{slug}', [CheckController::class, 'viewResponse'])->name('user.compliance.view');
    Route::post('resend-compliance/{slug}', [CheckController::class, 'resendCompliance'])->name('resend.compliance');
    Route::get('suspend-user/{id}', [CheckController::class, 'suspendUser'])->name('admin.suspend');
    Route::get('block-user/{id}', [CheckController::class, 'blockUser'])->name('user.block');
    Route::post('block-user/{id}', [CheckController::class, 'terminateAccount'])->name('user.terminate');
    Route::post('suspend-user/{id}', [CheckController::class, 'postSuspend'])->name('user.postSuspend');
    Route::get('read-message/{id}', [CheckController::class, 'Readmessage'])->name('read.message');
    Route::get('unread-message/{id}', [CheckController::class, 'Unreadmessage'])->name('unread.message');
    Route::get('manage-user/{id}', [CheckController::class, 'Manageuser'])->name('user.manage');
    Route::get('manage-staff/{id}', [CheckController::class, 'Managestaff'])->name('staff.manage');
    Route::delete('user/delete/{id}', [CheckController::class, 'Destroyuser'])->name('user.delete');
    Route::get('staff/delete/{id}', [CheckController::class, 'Destroystaff'])->name('staff.delete');
    Route::get('email/{email}/{name}', [CheckController::class, 'Email'])->name('admin.email');
    Route::post('email_send', [CheckController::class, 'Sendemail'])->name('user.email.send');
    Route::get('promo', [CheckController::class, 'Promo'])->name('admin.promo');
    Route::post('promo', [CheckController::class, 'Sendpromo'])->name('user.promo.send');
    Route::get('message/delete/{id}', [CheckController::class, 'Destroymessage'])->name('message.delete');
    Route::get('ticket', [CheckController::class, 'Ticket'])->name('admin.ticket');
    Route::get('ticket/delete/{id}', [CheckController::class, 'Destroyticket'])->name('ticket.delete');
    Route::get('close-ticket/{id}', [CheckController::class, 'Closeticket'])->name('ticket.close');
    Route::get('manage-ticket/{id}', [CheckController::class, 'Manageticket'])->name('ticket.manage');
    Route::post('reply-ticket', [CheckController::class, 'Replyticket'])->name('ticket.reply');
    Route::post('profile-update', [CheckController::class, 'Profileupdate']);
    Route::post('staff-update', [CheckController::class, 'Staffupdate'])->name('staff.update');
    Route::get('approve-kyc/{id}', [CheckController::class, 'Approvekyc'])->name('admin.approve.kyc');
    Route::post('reject-kyc', [CheckController::class, 'Rejectkyc'])->name('admin.reject.kyc');
    Route::post('password', [CheckController::class, 'staffPassword'])->name('staff.password');

    //Merchant controller
    Route::get('merchant-log', [MerchantController::class, 'merchantlog'])->name('merchant.log');
    Route::get('transfer-log/{id}', [MerchantController::class, 'transferlog'])->name('transfer.log');
    Route::get('merchant/delete/{id}', [MerchantController::class, 'Destroymerchant'])->name('merchant.delete');

    //Trade controller
    Route::get('trades', [TradeController::class, 'trades'])->name('admin.trades');
    Route::get('delete/{id}', [TradeController::class, 'DestroyTrade'])->name('trade.delete');
    Route::get('approvetrade/{id}', [TradeController::class, 'approveTrade'])->name('trade.approve');
    Route::get('declinetrade/{id}', [TradeController::class, 'declineTrade'])->name('trade.decline');

    //Vcard
    Route::get('vcard', [CheckController::class, 'vcard'])->name('admin.vcard');
    Route::get('transactions-virtual/{id}', [CheckController::class, 'transactionsvcard'])->name('transactions.vcard');

    //Fund Category
    Route::group(['prefix' => 'fund_cateogry'], function () {
        Route::get('index', [FundcategoryController::class, 'index'])->name('fc.index');
        Route::get('delete/{id}', [FundcategoryController::class, 'delete'])->name('fc.delete');
        Route::post('update', [FundcategoryController::class, 'update'])->name('fc.update');
        Route::post('create', [FundcategoryController::class, 'store'])->name('fc.create');
        Route::get('disable/{id}', [FundcategoryController::class, 'disable'])->name('fc.disable');
        Route::get('enable/{id}', [FundcategoryController::class, 'active'])->name('fc.active');
    });
    Route::group(['prefix' => 'mcc'], function () {
        Route::get('index', [MccController::class, 'index'])->name('mcc.index');
        Route::get('delete/{id}', [MccController::class, 'delete'])->name('mcc.delete');
        Route::post('update', [MccController::class, 'update'])->name('mcc.update');
        Route::post('create', [MccController::class, 'store'])->name('mcc.create');
        Route::get('disable/{id}', [MccController::class, 'disable'])->name('mcc.disable');
        Route::get('enable/{id}', [MccController::class, 'active'])->name('mcc.active');
    });
    Route::group(['prefix' => 'custom_domain'], function () {
        Route::get('index', [CheckController::class, 'custom_domain'])->name('domain.index');
        Route::get('enable/{id}', [CheckController::class, 'activate_domain'])->name('domain.active');
    });
    Route::group(['prefix' => 'subscription'], function () {
        Route::get('/', [SubscriptionPlanController::class, 'showAdminPlans'])->name('admin.plans');
        Route::post('/update/{id}', [SubscriptionPlanController::class, 'updateAdminPlans'])->name('update.admin.plans');
    });
    Route::group(['prefix' => 'waiting-list'], function () {
        Route::get('/', [WaitingListController::class, 'showWaitingList'])->name('admin.waiting');
    });
    //End
});

Route::group(['prefix' => 'compliance-verification'], function () {
    // Route::post('verification', [App\Http\Controllers\SumsubComplianceController::class, 'store']);
    Route::post('decision', [App\Http\Controllers\SumsubComplianceController::class, 'sumSubWebhook']);
});
// Route::post('compliance-verification/decision', [App\Http\Controllers\SumsubComplianceController::class, 'sumSubWebhook']);
// Route::post('compliance-verification/decision', [AccountController::class, 'sumSubWebhook']);
// Route::post('compliance-verification/decision', [AccountController::class, 'veriffDecisionWebhook']);
// Route::post('compliance-verification/veriff', [PaymentController::class, 'veriffSubmissionWebhook']);


// Tell Connect Open Banking
Route::group(['prefix' => 'tell-connect'], function () {
    Route::get('/authorize', [TellConnectAuthController::class, 'login']);
    Route::post('/attempt-login', [TellConnectAuthController::class, 'attemptLogin'])->name('openbanking.login');
    Route::get('/approve-consent/{consentId}', [TellConnectAuthController::class, 'approveConsent'])->name('approve.consent');
    Route::get('/decide-consent/{consentId}/{decision}', [TellConnectAuthController::class, 'consentDecision'])->name('consent.decision');
    // Route::get('/user-consents', [TellConnectAuthController::class, 'getUserPermissions'])->name('openbanking.permissions');

});
Route::post('/banking-service/webhook-actions',        [App\Http\Controllers\NotificationController::class, 'addNotification']);

Route::get('zoho-domain-verification', function () {
    return view('user.zoho-domain-verification.html');
});
