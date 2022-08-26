<?php

use App\Models\BookingConfiguration;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Models\Settings;
use App\Models\Transactions;
use App\Models\Currency;
use App\Models\User;
use App\Models\Product;
use App\Models\Countrysupported;
use App\Models\Fundcategory;
use App\Models\Shipcountry;
use App\Models\Storefrontaddress;
use App\Models\HomepageSettings;
use App\Models\Storefront;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ThemeSliders;
use App\Models\ThemeFeature;
use App\Models\Storepages;
use App\Models\Productimage;
use App\Models\Storeblog;
use App\Models\Storeblogcat;
use App\Models\Storefaq;
use App\Models\Storereview;
use App\Models\Storeteam;
use App\Models\Bookings;
use App\Models\Storefaqcat;
use App\Models\Storebrand;
use App\Models\Customdomain;
use App\Models\Mcc;
use App\Models\BookingServices;
use App\Models\County;
use App\Models\Donations;
use App\Models\EmailAndSmsPricing;
use App\Models\Merchant;
use App\Models\MerchantCategoryCodes;
use App\Models\SubscriptionPlan;
use App\Models\WebsiteThemes;
use Illuminate\Support\Facades\Session;
use Spatie\CalendarLinks\Link;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Stripe\Issuing\Transaction;
use Illuminate\Support\Str;

function getUserHref($link, $store)
{
    $href = "#";
    if ($link["type"] == 'home') {
        $href = route('website.link', ['id' => $store->store_url]);
    } else if ($link["type"] == 'services') {
        $href = route('store.services.index', ['id' => $store->store_url]);
    } else if ($link["type"] == 'blog') {
        $href = route('store.blog.index', ['id' => $store->store_url]);
    } else if ($link["type"] == 'our_team') {
        $href = route('store.team.index', ['id' => $store->store_url]);
    } else if ($link["type"] == 'testimonials') {
        $href = route('store.review.index', ['id' => $store->store_url]);
    } else if ($link["type"] == 'faq') {
        $href = route('store.faq.index', ['id' => $store->store_url]);
    } else if ($link["type"] == 'products') {
        $href = route('store.products.index', ['id' => $store->store_url]);
    } else if ($link["type"] == 'custom') {
        if (empty($link["href"])) {
            $href = "javascript:void;";
        } else {
            $href = $link["href"];
        }
    }
    else {
        $pageid = (int)$link["type"];
        $page = Storepages::find($pageid);
        if (!empty($page)) {
            $href = route('store.page.view', ['id'=>$store->id, 'ref'=>$page->id, 'slug'=>$page->slug]);
        } else {
            $href = "#";
        }
    }
    return $href;
}
function updateEmailLimit($id){
    $user = User::find($id);
    $user->used_email = $user->used_email + 1;
    $user->save();
}

function updateSmsLimit($id){
    $user = User::find($id);
    $user->used_sms = $user->used_sms + 1;
    $user->save();
}

function calendar_google($from, $to, $name, $description)
{
    $from = Carbon::createFromFormat('Y-m-d H:i', Carbon::create($from)->format('Y-m-d H:i'));
    $to = Carbon::createFromFormat('Y-m-d H:i', Carbon::create($to)->format('Y-m-d H:i'));
    $link = Link::create($name, $from, $to)->description($description);
    return $link->google();
}
function calendar_apple($from, $to, $name, $description)
{
    $from = Carbon::createFromFormat('Y-m-d H:i', Carbon::create($from)->format('Y-m-d H:i'));
    $to = Carbon::createFromFormat('Y-m-d H:i', Carbon::create($to)->format('Y-m-d H:i'));
    $link = Link::create($name, $from, $to)->description($description);
    return $link->ics();
}
function randomNumber($length)
{
    $result = '';

    for ($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
}
function getServerIp()
{
    $serverName = str_replace(
        [
            'http://',
            'https://',
        ],
        '',
        env('APP_URL')
    );
    $serverIp   = gethostbyname($serverName);

    if ($serverIp == $_SERVER['SERVER_ADDR']) {
        $serverIp;
    } else {
        $serverIp = request()->server('SERVER_ADDR');
    }
    return $serverIp;
}
function getNameServers()
{
    $name = dns_get_record("tryba.io");
    return $name;
}
function getNameServersValue()
{
    foreach (dns_get_record("tryba.io", DNS_NS) as $val) {
        $ns[] = $val['target'];
    }
    return $ns;
}
function verifyNameServersValue($domain)
{
    foreach (dns_get_record($domain, DNS_NS) as $val) {
        $ns[] = $val['target'];
    }
    return $ns;
}
function getStartTime(){
    $startArr = [];
    for ($i=0; $i < 12 ; $i++) {
        array_push($startArr,$i);
    }
    return $startArr;
}

function getendTime(){
    $endArr = [];
    for ($i=12; $i < 24 ; $i++) {
        array_push($endArr,$i);
    }
    return $endArr;
}
function getTimeInterval($start)
{
    if ($start == 1) {
        $interval_gap = 15;
        $interval_start_time = strtotime("00:00");
        $interval_end_time = strtotime("12:00");
        while ($interval_start_time < $interval_end_time) {
            $interval_start_time_in_format = date("H:i", $interval_start_time);
            $interval_time_arr[$interval_start_time_in_format] = $interval_start_time_in_format;
            $interval_time_increase = date("H:i", strtotime('+' . $interval_gap . ' minutes', $interval_start_time));
            $interval_start_time = strtotime($interval_time_increase);
        }
    } else {
        $interval_gap = 15;
        $interval_start_time = strtotime("23:00");
        $interval_end_time = strtotime("12:00");
        while ($interval_start_time > $interval_end_time) {
            $interval_start_time_in_format = date("H:i", $interval_start_time);
            $interval_time_arr[$interval_start_time_in_format] = $interval_start_time_in_format;
            $interval_time_decrease = date("H:i", strtotime('-' . $interval_gap . ' minutes', $interval_start_time));
            $interval_start_time = strtotime($interval_time_decrease);
        }
    }
    return $interval_time_arr;
}
function getTimeIntervalByTime($start_time = "07:00am", $end_time = "10:00pm", $interval_gap = 15)
{

    $interval_start_time = strtotime($start_time);
    $interval_end_time = strtotime($end_time);
    while ($interval_start_time < $interval_end_time) {

        $interval_start_time_in_format = date("H:i", $interval_start_time);

        $interval_time_arr[] = $interval_start_time_in_format;

        $interval_time_increase = date("H:i", strtotime('+' . $interval_gap . ' minutes', $interval_start_time));
        $interval_start_time = strtotime($interval_time_increase);
    }

    return $interval_time_arr;
}
function getStorefront($id)
{
    return Storefront::wherestore_url($id)->firstOrFail();
}
function getCustomerAddress($id)
{
    return Storefrontaddress::wherecustomer_id($id)->orderby('id', 'desc')->get();
}
function getStorefrontDomain($domain)
{
    $customDomain = Customdomain::where('domain', $domain)->first();
    return Storefront::where('user_id',$customDomain->user_id)->first();
}
function getThemeSliders($id)
{
    return ThemeSliders::wherestore_id($id)->orderby('created_at', 'desc')->get();
}
function getCustomDomain($id)
{
    return Customdomain::wherestore_id($id)->orderby('created_at', 'desc')->first();
}
function getAllCustomDomain()
{
    return Customdomain::whereNotNull('domain')->orderby('status', 'desc')->get();
}
function getThemeSlidersActive($id, $limit=null)
{
    if($limit==null){
        return ThemeSliders::wherestore_id($id)->wherestatus(1)->orderby('created_at', 'desc')->get();
    }else{
        return ThemeSliders::wherestore_id($id)->wherestatus(1)->orderby('created_at', 'desc')->take($limit)->get();
    }
}

function getHeaderImage()
{
    return ThemeSliders::wherestatus(1)->orderby('created_at', 'desc')->first();
}

function getThemeFeature($id)
{
    return ThemeFeature::wherestore_id($id)->orderby('created_at', 'desc')->get();
}
function getThemes()
{
    return WebsiteThemes::all();
}
function getLayout($id)
{
    return HomepageSettings::wherestore_id($id)->first();
}
function themeSetting($id)
{
    return Storefront::template($id);
}
function getProductImage($id)
{
    return Productimage::whereproductId($id)->first();
}
function getProductReviews($id)
{
    return Order::whereproductId($id)->where('review', '!=', null)->get();
}
function getBookingReviews($id)
{
    return Bookings::whereserviceId($id)->where('review', '!=', null)->get();
}
function getProductRelated($cat, $id, $limit)
{
    return Product::wherecat_id($cat)->where('id', '!=', $id)->limit($limit)->get();
}
function getThemeFeatureActive($id)
{
    return ThemeFeature::wherestore_id($id)->wherestatus(1)->orderby('created_at', 'desc')->get();
}
function getStorePage($id)
{
    return Storepages::wherestore_id($id)->orderby('created_at', 'desc')->get();
}
function getStorePageActive($id)
{
    return Storepages::wherestore_id($id)->wherestatus(1)->orderby('created_at', 'desc')->get();
}
function getStoreBrand($id)
{
    return Storebrand::wherestore_id($id)->orderby('created_at', 'desc')->get();
}
function getStoreBrandActive($id)
{
    return Storebrand::wherestore_id($id)->wherestatus(1)->orderby('created_at', 'desc')->get();
}
function getStoreBlog($id)
{
    return Storeblog::wherestore_id($id)->orderby('created_at', 'desc')->get();
}
function getStoreCatArticles($id, $cat_id, $paginate = null)
{
    if ($paginate == null) {
        return Storeblog::wherestore_id($id)->wherecat_id($cat_id)->orderby('created_at', 'desc')->get();
    } else {
        return Storeblog::wherestore_id($id)->wherecat_id($cat_id)->orderby('created_at', 'desc')->paginate(6);
    }
}
function getStoreBlogCat($id)
{
    return Storeblogcat::wherestore_id($id)->orderby('created_at', 'desc')->get();
}
function getStoreFaq($id)
{
    return Storefaq::wherestore_id($id)->orderby('created_at', 'desc')->get();
}
function getStoreFaqSingle($id, $cat)
{
    return Storefaq::wherestore_id($id)->wherecat_id($cat)->orderby('created_at', 'desc')->get();
}
function getStoreReview($id)
{
    return Storereview::wherestore_id($id)->orderby('created_at', 'desc')->get();
}
function getStoreReviewActive($id, $limit=null)
{
    if($limit==null){
        return Storereview::wherestore_id($id)->wherestatus(1)->orderby('created_at', 'desc')->get();
    }else{
        return Storereview::wherestore_id($id)->wherestatus(1)->orderby('created_at', 'desc')->take($limit)->get();
    }
}
function getTeam($id)
{
    return Storeteam::where('websiteId',$id)->orderby('created_at', 'desc')->get();
}
function getStoreFaqCat($id)
{
    return Storefaqcat::wherestore_id($id)->orderby('created_at', 'desc')->get();
}
function getStoreServices($id)
{
    return BookingServices::wherestore_id($id)->orderBy('created_at', 'desc')->get();
}
function getMcc()
{
    return Mcc::wherestatus(1)->orderby('name', 'desc')->get();
}
function getMccType($id)
{
    return Mcc::find($id);
}
function getStoreBlogActive($id, $limit = null)
{
    if ($limit == null) {
        return Storeblog::wherestore_id($id)->wherestatus(1)->orderby('created_at', 'desc')->get();
    } else {
        return Storeblog::wherestore_id($id)->wherestatus(1)->orderby('created_at', 'desc')->paginate($limit);
    }
}
function getStoreTeamActive($id, $limit = null)
{
    if ($limit == null) {
        return Storeteam::wherestore_id($id)->wherestatus(1)->orderby('created_at', 'desc')->get();
    } else {
        return Storeteam::wherestore_id($id)->wherestatus(1)->orderby('created_at', 'desc')->paginate($limit);
    }
}
function getStoreBlogPrevious($id, $blog)
{
    return Storeblog::wherestore_id($id)->where('id', '<', $blog)->wherestatus(1)->first();
}
function getStoreBlogNext($id, $blog)
{
    return Storeblog::wherestore_id($id)->where('id', '>', $blog)->wherestatus(1)->first();
}

function getStoreProducts($id, $limit)
{
    return  Product::whereuser_id($id)->wherestatus(1)->orderby('id', 'desc')->paginate($limit);
}
function getStoreProductsType($id, $limit, $type = null)
{
    if ($type == null || $type == "arrivals") {
        return  Product::whereuser_id($id)->wherestatus(1)->where('cat_id', '!=', 0)->orderby('created_at', 'desc')->paginate($limit);
    } elseif ($type == "sellers") {
        return  Product::whereuser_id($id)->wherestatus(1)->where('cat_id', '!=', 0)->orderby('sold', 'desc')->paginate($limit);
    } elseif ($type == "viewed") {
        return  Product::whereuser_id($id)->wherestatus(1)->where('cat_id', '!=', 0)->orderby('views', 'desc')->paginate($limit);
    } elseif ($type == "featured") {
        return  Product::whereuser_id($id)->wherestatus(1)->where('cat_id', '!=', 0)->wherefeatured(1)->paginate($limit);
    }
}
function getStorefrontCart($id)
{
    return  Cart::where('uniqueid', Session::get('uniqueid'))->wherestore($id)->get();
}
function getStorefrontCartFirst($id)
{
    return  Cart::where('uniqueid', Session::get('uniqueid'))->wherestore($id)->first();
}
function getStorefrontCartTotal($id)
{
    return  Cart::where('uniqueid', Session::get('uniqueid'))->wherestore($id)->sum('total');
}
function getStorefrontOwner($id)
{
    return User::whereid($id)->first();
}
function getProductCategory()
{
    return Fundcategory::wherestatus(1)->orderby('name', 'asc')->get();
}
function getShipping()
{
    //Return United Kindom for now
    return Shipcountry::whereid(232)->get();
}
function getPhone()
{
    return Shipcountry::whereid(232)->orderby('phonecode', 'asc')->get();
}

function getInvoiceState($iso){
    $country = Shipcountry::whereiso2($iso)->orderby('name', 'asc')->first();
    return County::wherecountry_id($country->id)->orderby('name', 'asc')->get();
}

function getSupportedCountries()
{
    return Countrysupported::wherestatus(1)->get();
}
function getSetting()
{
    return Settings::first();
}
function getMarketCategory($cat)
{
    return Product::wherecat_id($cat)->wherestatus(1)->count();
}
function getCategory($cat, $user, $mode)
{
    return Product::wherecat_id($cat)->whereuser_id($user)->wheremode(1)->count();
}
function checkCategory($cat)
{
    return Fundcategory::whereid($cat)->count();
}
function send_webhook($id)
{
    $link = Transactions::whereid($id)->first();
    $user = User::whereid($link->receiver_id)->first();
    $url = $user->webhook;
    $currency = Currency::whereid($link->currency)->first();
    if ($link->sender_id != null) {
        $payer = User::whereid($link->sender_id)->first();
        $email = $payer->email;
        $first_name = $payer->first_name;
        $last_name = $payer->last_name;
    } else {
        $email = $link->email;
        $first_name = $link->first_name;
        $last_name = $link->last_name;
    }
    if ($link->mode == 1) {
        $mode = "live";
    } else {
        $mode = "test";
    }
    if ($link->status == 1) {
        $status = "success";
    } else {
        $status = "failed";
    }
    if ($link->type == 2) {
        $type = "collection pot";
    } elseif ($link->type == 3) {
        $type = "invoice";
    } elseif ($link->type == 1) {
        $type = "test";
    } elseif ($link->type == 4) {
        $type = "subscription";
    }
    $data = [
        'status_code' => 200,
        'status' => $status,
        'message' => 'webhook send successfully',
        'extra_data' => [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'currency' => $currency->name,
            'amount' => number_format($link->amount, 2),
            'charge' => number_format($link->charge, 2),
            'mode' => $mode,
            'type' => $type,
            'reference' => $link->ref_id,
            'created_at' => $link->created_at,
            'updated_at' => $link->updated_at,
        ],
    ];
    $json_array = json_encode($data);
    $curl = curl_init();
    $headers = ['Content-Type: application/json'];
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_array);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($http_code >= 200 && $http_code < 300) {
        $link->webhook = 1;
        $link->save();
    } else {
        $link->webhook = 2;
        $link->save();
    }
}
function user_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
function convertFloat($floatAsString)
{
    $norm = strval(floatval($floatAsString));
    if (($e = strrchr($norm, 'E')) === false) {
        return $norm;
    }
    return number_format($norm, -intval(substr($e, 1)));
}
function view_currency($from)
{
    if (Auth::guard('user')->check()) {
        $xf = Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        $currency = Currency::whereid($xf->coin_id)->first();
        $result = $currency->symbol;
        return $result;
    } else {
        $currency = Currency::whereid($from)->first();
        $result = $currency->symbol ?? '';
        return $result;
    }
}
function getUserCurrency($user){
    $xf = Countrysupported::whereid($user->pay_support)->first();
    $currency = Currency::whereid($xf->coin_id)->first();
    $result = $currency->symbol;
    return $result;
}
function getUserCurrencyDetails($user){
    $xf = Countrysupported::whereid($user->pay_support)->first();
    $currency = Currency::whereid($xf->coin_id)->first();
    return $currency;
}
function getUserCurrencyName($user){
    $xf = Countrysupported::whereid($user->pay_support)->first();
    $currency = Currency::whereid($xf->coin_id)->first();
    $result = $currency->name;
    return $result;
}

function view_currency2($from)
{
    $currency = Currency::whereid($from)->first();
    $result = $currency->symbol;
    return $result;
}

function getAmountDonated($id){
    return Donations::wheredonation_id($id)->wherestatus(1)->sum('amount');
}

function getLatestBlogPost($id,$limit)
{
   return Storeblog::where('store_id',$id)->latest()->take($limit)->get();
}

function successMonthlyTransactions()
{
    $user = Auth::user();
  
    $plan = SubscriptionPlan::where('id',$user->plan_id)->first();

    $planstartDate = Carbon::parse($user->plan_expiring)->subMonths($plan->duration);
    return Transactions::whereReceiverId($user->id)->whereMode($user->live)->whereStatus(1)->where('type', '!=', 9)->whereBetween('created_at',
    [$planstartDate, $user->plan_expiring])->sum('amount');
}

function GetUserMonthlyTransactions($id)
{
    $user = User::whereid($id)->first();
    return Transactions::whereReceiverId($user->id)->whereMode($user->live)->whereStatus(1)->where('type', '!=', 9)->whereBetween('created_at',
    [$user->plan_startDate, $user->plan_expiring])->sum('amount');
}


function getNextSubscriptionPlan($id){
    return SubscriptionPlan::whereid($id)->first();
}

function getFiveTrx($id,$mode){
    return Transactions::where('receiver_id',$id)->where('mode',$mode)->latest()->take(5)->get();
}

function getWebsiteCart(){
    $websiteCart = json_decode(Cookie::get('websiteCart'));
    return (!empty($websiteCart)) ? $websiteCart : [];
}

function pluarize($text,$count){
    return Str::plural($text, $count);
}

function getMerchantCodes()
{
    return MerchantCategoryCodes::all();
}

function getCurrentDateWorkingHours($id){
    $websiteBookingConfiguration = BookingConfiguration::where('websiteID',$id)->first();
    if ($websiteBookingConfiguration->businessHours[strtolower(now()->dayName)]['status'] == 1) {
        $array = $websiteBookingConfiguration->businessHours[strtolower(now()->dayName)];
        $hours = [];
        for($i = $array['startTime']; $i <= $array['endTime']; $i++) {
            if (intval(now()->hour) < $i) {
                array_push($hours,$i);
            }
        }
        return $hours;
    }else{
        return [];
    }
}
function getEmailPricePerUnit()
{
    $pricemodel = EmailAndSmsPricing::first();
    if (!empty($pricemodel)) {
        return round($pricemodel->amount_email / $pricemodel->quantity_email,2);
    }else{
        return '0.00';
    }

}

function getSMSPricePerUnit()
{
    $pricemodel = EmailAndSmsPricing::first();
    if (!empty($pricemodel)) {
        return round($pricemodel->amount_sms / $pricemodel->quantity_sms,2);
    }else{
        return '0.00';
    }
}

function getLiveCode(){
    $setting = Settings::first();
    return $setting->livechat;
}

