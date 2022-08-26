<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Jobs\SendUsersEmailFromWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Settings;
use App\Models\BookingServices;
use App\Models\Product;
use App\Models\Order;
use App\Models\Countrysupported;
use App\Models\Productimage;
use App\Models\Storefront;
use App\Models\Storefrontcustomer;
use App\Models\Storefrontaddress;
use App\Models\Shipping;
use App\Models\Shipcity;
use App\Models\Shipcountry;
use App\Models\Shipstate;
use App\Models\Bookings;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Transactions;
use App\Models\Wishlist;
use App\Models\Fundcategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Curl\Curl;
use Stripe\StripeClient;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Models\Storeblog;
use App\Models\Storepages;
use App\Models\Coupon;
use App\Mail\StorefrontEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\BookingConfiguration;
use App\Models\County;
use App\Models\Services;
use App\Models\Website;
use App\Models\WebsiteThemes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class OfflineController extends Controller
{
    public function __construct()
    {
        $this->settings = Settings::find(1);
    }
    public function storelink($id, $type = null)
    {
       $website = Website::where('websiteUrl',$id)->firstorFail();
       $theme = WebsiteThemes::where('id',$website->theme_id)->first();
       return view('user.website.themes.'.strtolower($theme->themeName).'.index',[
           'title' => 'Home',
           'website' => $website
       ]);
    }

    public function about($id)
    {
       $website = Website::where('websiteUrl',$id)->firstorFail();
       $theme = WebsiteThemes::where('id',$website->theme_id)->first();
       return view('user.website.themes.'.strtolower($theme->themeName).'.pages.about',[
           'title' => 'About',
           'website' => $website
       ]);
    }

    public function blog($id)
    {
       $website = Website::where('websiteUrl',$id)->firstorFail();
       $theme = WebsiteThemes::where('id',$website->theme_id)->first();
       return view('user.website.themes.'.strtolower($theme->themeName).'.pages.blog',[
           'title' => 'Blog',
           'website' => $website
       ]);
    }

    public function contact($id)
    {
       $website = Website::where('websiteUrl',$id)->firstorFail();
       $theme = WebsiteThemes::where('id',$website->theme_id)->first();
       return view('user.website.themes.'.strtolower($theme->themeName).'.pages.contact',[
           'title' => 'Contact',
           'website' => $website
       ]);
    }

    public function sendResponse(Request $request,$id){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'email' =>'required|email',
            'phone' => 'required',
            'message' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()],422);
        }

        $website = Website::where('websiteUrl',$id)->first();

        dispatch_sync(new SendUsersEmailFromWebsite($request->all(),$website->user));

        return response()->json(['success' => 'Thank you for contacting us we will be with you shortly!'],200);
    }

    function getWorkingHours(Request $request,$id){
        $validator = Validator::make( $request->all(),[
            'date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()],422);
        }
        $websiteBookingConfiguration = BookingConfiguration::where('websiteID',$id)->first();
        if ($websiteBookingConfiguration->businessHours[strtolower(Carbon::parse($request->date)->dayName)]['status'] == 1) {
            $array = $websiteBookingConfiguration->businessHours[strtolower(Carbon::parse($request->date)->dayName)];
            $hours = [];
            if (Carbon::parse($request->date)->format('Y-m-d') == now()->format('Y-m-d')) {
                for($i = $array['startTime']; $i <= $array['endTime']; $i++) { 
                    if (intval(now()->hour) < $i) {
                        array_push($hours,$i);
                    }
                }
            }else{
                for($i = $array['startTime']; $i <= $array['endTime']; $i++) { 
                    array_push($hours,$i);
                }
            }
            return $hours;
        }else{
            return [];
        }
    }
    
    public function addToCart($id,$service,Request $request){
        $validator = Validator::make( $request->all(),[
            'date' => 'required|date',
            'time' => 'integer'
        ]);
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $website = Website::where('websiteUrl',$id)->first();
        $array = $website->bookingConfiguration->businessHours[strtolower(Carbon::parse($request->date)->dayName)];
        $service = BookingServices::where('id',$service)->first();
        if (Carbon::parse($request->date)->format('Y-m-d') == now()->format('Y-m-d')) {
            $hours = [];
            for($i = $array['startTime']; $i <= $array['endTime']; $i++) { 
                if (intval(now()->hour) < $i) {
                    array_push($hours,$i);
                }
            }
            if(in_array($request->time,$hours)){
                //Addtocart
                $this->addServicetoCart($service,$request->date,$request->time);
            }else{
                return back()->with('errors', 'Cannot make a booking for this time schedule another time');
            }
        }else{
            //AddtoCart
            $this->addServicetoCart($service,$request->date,$request->time);
        }
        return redirect()->route('website.getCart',['id' => $website->websiteUrl])->with('msg','Successfully added product to cart');
    }

    public function addServicetoCart($service,$date,$time){

        $cartCookie = Cookie::get('websiteCart');
        $cart = json_decode($cartCookie,true);
        if(empty($cartCookie)){
              $cartService = [
                ['id' => $service->id , 'service' => $service,'date'  =>  $date,'time' => $time]
              ];
              $cartJson = json_encode($cartService);
        }elseif(array_search($service->id,array_column($cart,'id')) !== false ){
              $key = array_search($service->id,array_column($cart,'id'));
              $cart[$key] = ['id' => $service->id , 'service' => $service,'date'  =>  $date,'time' => $time];
              $cartJson = json_encode($cart);
        }else{
              $cart = json_decode($cartCookie,true);
              $cartService =  ['id' => $service->id , 'service' => $service,'date' =>  $date,'time' => $time];
              array_push($cart,$cartService); 
              $cartJson = json_encode($cart);
        }

        Cookie::queue(Cookie::make('websiteCart',$cartJson,10080));
    }

    public function showCart($id)
    {
        $website = Website::where('websiteUrl',$id)->firstorFail();
        $theme = WebsiteThemes::where('id',$website->theme_id)->first();
        return view('user.website.themes.'.strtolower($theme->themeName).'.pages.cart',[
            'title' => 'Cart',
            'website' => $website
        ]);
    }

    public function removeService($id,$service){
        $cartCookie = Cookie::get('websiteCart');
        $cart = json_decode($cartCookie,true);
        $key = array_search($service,array_column($cart,'id'));
        unset($cart[$key]);
        $cartJson = json_encode($cart);
        Cookie::queue(Cookie::make('websiteCart',$cartJson,10080));

        return redirect()->route('website.getCart',['id' => $id])->with('msg','Successfully added product to cart');
    }

    public function generatereceipt($id)
    {
        $data['link'] = $trans = Transactions::whereref_id($id)->first();
        if ($trans->status == 1) {
            $data['title'] = "Receipt from " . $trans->receiver->first_name . ' ' . $trans->receiver->last_name;
            $data['trans'] = $trans;
            $data['merchant'] = User::find($trans->receiver_id);
            return view('user.transactions.receipt', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function storeArticles($id)
    {
        $data['store'] = $store = Storefront::wherestore_url($id)->first();
        $data['title'] = 'Articles';
        return view('user.product.theme.' . $store->theme_id . '.blog', $data);
    }
    public function services($id)
    {
        $website = Website::where('websiteUrl',$id)->firstorFail();
        $theme = WebsiteThemes::where('id',$website->theme_id)->first();
        $services = BookingServices::where('user_id',$website->user->id)->where('status',1)->get();
        return view('user.website.themes.'.strtolower($theme->themeName).'.pages.services',[
            'title' => 'Services',
            'website' => $website,
            'services' => $services
        ]);
    }

    public function singleService($id,$service)
    {
        $website = Website::where('websiteUrl',$id)->firstorFail();
        $theme = WebsiteThemes::where('id',$website->theme_id)->first();
        $service = BookingServices::where('id',$service)->where('user_id',$website->user->id)->first();
        return view('user.website.themes.'.strtolower($theme->themeName).'.pages.services-item',[
            'title' => $service->name,
            'website' => $website,
            'service' => $service
        ]);
    }
    public function storeBook($id, $service, $coupon = null)
    {
        $data['store'] = $store = Storefront::wherestore_url($id)->first();
        $data['service'] = $service = BookingServices::whereid($service)->first();
        if ($coupon == null) {
            $data['allsum'] = $allsum = $service->price;
            $data['coupon_status'] = 0;
        } else {
            if (Coupon::wherecode($coupon)->count() > 0) {
                $data['coupon'] = $ddd = Coupon::wherecode($coupon)->first();
                if ($ddd->type == 1) {
                    $data['coupon_amount'] = $ddd->amount;
                } else {
                    $data['coupon_amount'] = $service->price * $ddd->amount / 100;
                }
                $data['allsum'] = $allsum = $service->price - $data['coupon_amount'];
                $data['coupon_status'] = 1;
            } else {
                $data['allsum'] = $allsum = $service->price;
            }
        }
        $data['title'] = $service->name;
        $data['total'] = ($allsum * $store->tax / 100) + $allsum;
        return view('user.product.theme.' . $store->theme_id . '.book.book', $data);
    }
    public function bookcoupon(Request $request, $id)
    {
        $service = BookingServices::whereid($id)->first();
        $store = Storefront::whereid($service->store_id)->firstOrFail();
        if (Coupon::wherecode($request->code)->whereuser_id($store->user_id)->count() > 0) {
            $coupon = Coupon::wherecode($request->code)->whereuser_id($store->user_id)->first();
            if ($coupon->limits != 0) {
                if ($coupon->type == 1) {
                    if ($service->price > $coupon->amount || $service->price == $coupon->amount) {
                        return redirect()->route('store.services.book', ['id' => $store->store_url, 'service' => $service->id, 'coupon' => $request->code])->with('success', 'Coupon Applied');
                    } else {
                        return back()->with('warning', 'Invalid Coupon!');
                    }
                } else {
                    return redirect()->route('store.services.book', ['id' => $store->store_url, 'service' => $service->id, 'coupon' => $request->code])->with('success', 'Coupon Applied');
                }
            } else {
                return back()->with('warning', 'Invalid Coupon!');
            }
        } else {
            return back()->with('warning', 'Invalid Coupon!');
        }
    }
    public function storeTeam($id)
    {
        $data['store'] = $store = Storefront::wherestore_url($id)->first();
        $data['title'] = 'Team';
        return view('user.product.theme.' . $store->theme_id . '.team', $data);
    }
    public function storeReview($id)
    {
        $data['store'] = $store = Storefront::wherestore_url($id)->first();
        $data['title'] = 'Review';
        return view('user.product.theme.' . $store->theme_id . '.review', $data);
    }
    public function storeFaq($id)
    {
        $data['store'] = $store = Storefront::wherestore_url($id)->firstorFail();
        $data['title'] = 'Faq';
        $data['id'] = $id;
        return view('user.product.theme.' . $store->theme_id . '.faq', $data);
    }
    public function storeProducts(Request $request ,$id)
    {
        $data['store'] = $store = Storefront::wherestore_url($id)->first();
        $data['title'] = 'Products';
        return redirect()->route('store.index',['id' => $store->store_url ]);
    }
    public function storeBlogView($id, $ref, $slug)
    {
        $data['store'] = $store = Storefront::whereid($id)->first();
        $data['blog'] = $blog = Storeblog::whereid($ref)->first();
        $blog->views = $blog->views + 1;
        $blog->save();
        $data['title'] = $blog->title;
        return view('user.product.theme.' . $store->theme_id . '.article', $data);
    }
    public function storePageView($id, $ref, $slug)
    {
        $data['store'] = $store = Storefront::whereid($id)->first();
        $data['page'] = $page = Storepages::whereid($ref)->first();
        $data['title'] = $page->title;
        return view('user.product.theme.' . $store->theme_id . '.page', $data);
    }
    public function storecat($id, $cat)
    {
        $data['store'] = $store = getStorefront($id);
        if ($store->user->status == 0) {
            $rr = Fundcategory::whereid($cat)->first();
            $data['cart'] = getStorefrontCart($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $data['products'] = Product::whereuser_id($store->user_id)->wherecat_id($cat)->orderby('id', 'desc')->paginate($store->product_per_page);
            $data['title'] = $store->store_name;
            $data['cat'] = $rr;
            $data['category'] = getProductCategory();
            return view('user.product.theme.' . $store->theme_id . '.category', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function checkproduct(Request $request)
    {
        $xtoken = randomNumber(11);
        $total = $request->amount + $request->shipping_fee - $request->coupon;
        $cart = Cart::whereuniqueid($request->product_id)->get();
        $cartf = Cart::whereuniqueid($request->product_id)->first();
        $merchant = Storefront::whereid($cartf->store)->first();

        $up_mer = User::whereid($merchant->user_id)->first();
        $currency = Countrysupported::whereid($up_mer->pay_support)->first();
        if (Auth::guard('customer')->check() && $merchant->id == Auth::guard('customer')->user()->store_id) {
            $validator = Validator::make(
                $request->all(),
                [
                    'shipping' => 'required',
                ]
            );
            if ($validator->fails()) {
                return back()->with('errors', $validator->errors());
            }
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required',
                    'shipping' => 'required',
                ]
            );
            if ($validator->fails()) {
                return back()->with('errors', $validator->errors());
            }
            $validatorf = new EmailValidator();
            $multipleValidations = new MultipleValidationWithAnd([
                new RFCValidation(),
                new DNSCheckValidation()
            ]);
            if ($validatorf->isValid($request->email, $multipleValidations)) {
            } else {
                return back()->with('warning', 'Invalid email address');
            }
            session::put('email', $request->email);
            session::put('note', $request->note);
            session::put('state', $request->state);
            session::put('city', $request->city);
        }
        $diff = $up_mer->plan_payments - $up_mer->used_payments;
        if ($total < $diff || $total == $diff) {
            if ($up_mer->plan_transactions > $up_mer->used_transactions) {
                $track = randomNumber(11);
                foreach ($cart as $checkout) {
                    $pro = Product::whereid($checkout->product)->first();
                    $rex = new Order();
                    $rex->quantity = $checkout->quantity;
                    $rex->seller_id = $merchant->user_id;
                    if (Auth::guard('customer')->check() && $merchant->id == Auth::guard('customer')->user()->store_id) {
                        $rex->customer_id = Auth::guard('customer')->user()->id;
                        $aa = explode('-', $request->shipping);
                        $address = Storefrontaddress::whereid($aa[0])->first();
                        $rex->line_1 = $address->line_1;
                        $rex->line_2 = $address->line_2;
                        $rex->country = $address->country->id;
                        $rex->state = $address->states->id;
                        if ($address->city != null) {
                            $rex->city = $address->cities->name;
                        }
                        $rex->postal_code = $address->postal_code;
                    } else {
                        $state = explode('*', $request->shipping);
                        //$rex->first_name = $request->first_name;
                        //$rex->last_name = $request->last_name;
                        $rex->email = $request->email;
                        //$rex->phone = $phone;
                        //$cc = explode("*", $request->shipping);
                        //$rex->line_1 = $request->line_1;
                        //$rex->country = $cc[1];
                        $rex->state = $state[1];
                        //$rex->line_2 = $request->line_2;
                        //$rex->city = $request->city;
                        $rex->postal_code = $request->postal_code;
                    }
                    if ($request->coupon_status == 1) {
                        $coupon = Coupon::wherecode($request->coupon_code)->first();
                        if ($coupon->type == 1) {
                            $rex->amount = $checkout->cost;
                            $rex->total = $checkout->total + $request->shipping_fee + ($checkout->cost * $merchant->tax / 100) - $coupon->amount;
                            $rex->tax = $checkout->cost * $merchant->tax / 100;
                            $rex->coupon = $coupon->amount;
                        } else {
                            $kk = $checkout->total + $request->shipping_fee + ($checkout->cost * $merchant->tax / 100);
                            $rex->amount = $checkout->cost;
                            $rex->total = $kk - ($kk * $coupon->amount / 100);
                            $rex->tax = $checkout->cost * $merchant->tax / 100;
                            $rex->coupon = $kk * $coupon->amount / 100;
                        }
                        $rex->coupon_code = $request->coupon_code;
                    } else {
                        $rex->amount = $checkout->cost;
                        $rex->total = $checkout->total + $request->shipping_fee + ($checkout->cost * $merchant->tax / 100);
                        $rex->tax = $checkout->cost * $merchant->tax / 100;
                        $rex->coupon = $checkout->cost * $merchant->tax / 100;
                    }
                    $rex->note = $request->note;
                    $rex->ref_id = $xtoken;
                    $rex->order_id = $track;
                    $rex->product_id = $checkout->product;
                    $rex->store_id = $checkout->store;
                    $rex->currency = $currency->coin_id;
                    $rex->payment_method = $request->action;
                    if (Auth::guard('customer')->check() && $merchant->id == Auth::guard('customer')->user()->store_id) {
                        $dd = explode("-", $request->shipping);
                        $rex->shipping_fee = trim($dd[1]);
                    } else {
                        $dd = explode("*", $request->shipping);
                        $rex->shipping_fee = trim($dd[2]);
                    }
                    $rex->ship_id = $request->xship;
                    if ($request->action == 'test') {
                        $rex->status = $request->status;
                    } else {
                        $rex->status = 0;
                    }
                    $rex->mode = 1;
                    $rex->size = $cartf->size;
                    $rex->color = $cartf->color;
                    $rex->length = $cartf->length;
                    $rex->weight = $cartf->weight;
                    $rex->save();
                    if ($request->action == 'test') {
                        $pro->quantity = $pro->quantity - $checkout->quantity;
                        $pro->sold = $pro->sold + $checkout->quantity;
                        $pro->save();
                    }
                }
                $sav = new Transactions();
                $sav->ref_id = $xtoken;
                $sav->type = 8;
                $sav->amount = $total;
                if (Auth::guard('customer')->check() && $merchant->id == Auth::guard('customer')->user()->store_id) {
                    $sav->email = Auth::guard('customer')->user()->email;
                    $sav->first_name = Auth::guard('customer')->user()->first_name;
                    $sav->last_name = Auth::guard('customer')->user()->last_name;
                } else {
                    $sav->email = $request->email;
                    //$sav->first_name = $request->first_name;
                    //$sav->last_name = $request->last_name;
                }

                $sav->ip_address = user_ip();
                $sav->receiver_id = $merchant->user_id;
                $sav->payment_type = $request->action;
                $sav->currency = $currency->coin_id;
                $sav->track_no = $track;
                $sav->paid = 1;
                $sav->payment_link = $rex->id;
                if ($request->action == 'test') {
                    $sav->status = $request->status;
                } else {
                    $sav->mode = 1;
                    $sav->status = 0;
                }
                $sav->save();
                if ($request->action == 'bank') {
                    //Generate Auth Key
                    $authToken = base64_encode($currency->auth_key . ':' . $currency->auth_secret);
                    $curl = new Curl();
                    $curl->setHeader('Authorization', 'Basic ' . $authToken);
                    $curl->setHeader('Content-Type', 'application/json');
                    $curl->get("https://api.yapily.com/institutions");
                    $response = $curl->response;
                    $curl->close();
                    if ($curl->error) {
                        return back()->with('warning', $response->error->status . '-' . $response->error->message);
                    } else {
                        Cache::put('trans', $xtoken);
                        $data['authtoken'] = $authToken;
                        $data['institution'] = $response->data;
                        $data['title'] = 'Select Preferred Bank';
                        $data['type'] = 8;
                        $data['reference'] = $xtoken;
                        return view('user.dashboard.institution', $data);
                    }
                } elseif ($request->action == 'coinbase') {
                    $data = [
                        'name' => $merchant->store_name,
                        'description' => $merchant->store_name . ' Storefront Purchase',
                        'pricing_type' => 'fixed_price',
                        'metadata' => array('customer_id' => $sav->ref_id, 'customer_name' => $sav->first_name . ' ' . $sav->last_name),
                        'local_price' => array('amount' => $sav->amount, 'currency' => $currency->coin->name),
                        'redirect_url' => route('coinbasesuccess', ['id' => $sav->ref_id]),
                        'cancel_url' => route('coinbasecancelled', ['id' => $sav->ref_id])
                    ];
                    $curl = new Curl();
                    $curl->setHeader('X-CC-Api-Key', $up_mer->coinbase_api_key);
                    $curl->setHeader('X-CC-Version', '2018-03-22');
                    $curl->setHeader('Content-Type', 'application/json');
                    $curl->post("https://api.commerce.coinbase.com/charges", $data);
                    $response = $curl->response;
                    $curl->close();
                    if ($curl->error) {
                        return back()->with('warning', $response->error->message);
                    } else {
                        $sav->charge_id = $response->data->code;
                        $sav->save();
                        return Redirect::away($response->data->hosted_url);
                    }
                } elseif ($request->action == 'paypal') {
                    $authToken = base64_encode($up_mer->paypal_client_id . ':' . $up_mer->paypal_secret_key);
                    $data = [
                        'intent' => "CAPTURE",
                        "purchase_units" => [
                            [
                                "amount" => [
                                    "currency_code" => $currency->coin->name,
                                    "value" => number_format($sav->amount, 2, '.', '')
                                ],
                            ]
                        ],
                        "application_context" => [
                            'return_url' => route('paypalsuccess', ['id' => $sav->ref_id]),
                            'cancel_url' => route('paypalcancelled', ['id' => $sav->ref_id])
                        ]
                    ];
                    $curl = new Curl();
                    $curl->setHeader('Authorization', 'Basic ' . $authToken);
                    $curl->setHeader('Content-Type', 'application/json');
                    $curl->post("https://api-m.paypal.com/v2/checkout/orders", $data);
                    $response = $curl->response;
                    $curl->close();
                    if ($curl->error) {
                        return back()->with('warning', $response->message);
                    } else {
                        $sav->charge_id = $response->id;
                        $sav->save();
                        return Redirect::away($response->links[1]->href);
                    }
                } elseif ($request->action == 'stripe') {
                    $stripe = new StripeClient($up_mer->stripe_secret_key);
                    try {
                        $charge = $stripe->checkout->sessions->create([
                            'success_url' => route('stripesuccess', ['id' => $sav->ref_id]),
                            'cancel_url' => route('stripecancelled', ['id' => $sav->ref_id]),
                            'payment_method_types' => ['card'],
                            'line_items' => [
                                [
                                    'name' => 'Storefront Purchase',
                                    'amount' => number_format($sav->amount, 2, '.', '') * 100,
                                    'currency' => $currency->coin->name,
                                    'quantity' => 1,
                                ],
                            ],
                            'mode' => 'payment',
                        ]);
                        $sav->charge_id = $charge['id'];
                        if ($charge['livemode'] == false) {
                            $sav->status = 2;
                            $sav->save();
                            return back()->with('warning', 'You can\'t use test keys');
                        }
                        $sav->save();
                        return Redirect::away($charge['url']);
                    } catch (\Stripe\Exception\CardException $e) {
                        return back()->with('warning', $e->getMessage());
                    } catch (\Stripe\Exception\InvalidRequestException $e) {
                        return back()->with('warning', $e->getMessage());
                    }
                }
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('Merchant have exceeded the number of transactions he/she can perform this month');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Amount Exceeds Merchant Subscription Payment Limit');
        }
    }
    public function checkbooking(Request $request)
    {
        $xtoken = randomNumber(11);
        $service = BookingServices::whereid($request->service_id)->first();
        $total = $service->price - $request->coupon;
        $merchant = Storefront::whereid($service->store_id)->first();
        $up_mer = User::whereid($service->user_id)->first();
        $currency = Countrysupported::whereid($up_mer->pay_support)->first();
        if ($service->storefront->service_type == 1) {
            $validator = Validator::make(
                $request->all(),
                [
                    'address' => 'required',
                ]
            );
            if ($validator->fails()) {
                return back()->with('errors', $validator->errors());
            }
        }
        $diff = $up_mer->plan_payments - $up_mer->used_payments;
        if ($total < $diff || $total == $diff) {
            if ($up_mer->plan_transactions > $up_mer->used_transactions) {
                $track = randomNumber(11);
                if ($merchant->session_time == 1) {
                    if (Bookings::wherestore_id($merchant->id)->wherestatus(1)->whered_date(Carbon::today())->whered_time($request->time)->count() > 0) {
                        return back()->with('warning', $request->time . " is already booked up");
                    }
                }
                if ($merchant->booking_per_day != null) {
                    if (Bookings::wherestore_id($merchant->id)->wherestatus(1)->whered_date(Carbon::today())->count() == $merchant->booking_per_day) {
                        return back()->with('warning', "Sorry we are all cut up for today");
                    }
                }
                $rex = new Bookings();
                $rex->customer_id = Auth::guard('customer')->user()->id;
                if ($service->storefront->service_type == 1) {
                    $address = Storefrontaddress::whereid($request->address)->first();
                    $rex->address_id = $address->id;
                    $rex->line_1 = $address->line_1;
                    $rex->line_2 = $address->line_2;
                    $rex->country = $address->country->id;
                    $rex->state = $address->states->id;
                    if ($address->city != null) {
                        $rex->city = $address->cities->name;
                    }
                    $rex->postal_code = $address->postal_code;
                }
                if ($request->coupon_status == 1) {
                    $coupon = Coupon::wherecode($request->coupon_code)->first();
                    if ($coupon->type == 1) {
                        $rex->amount = $service->price;
                        $rex->total = $service->price + ($service->price * $merchant->tax / 100) - $coupon->amount;
                        $rex->tax = $service->price * $merchant->tax / 100;
                        $rex->coupon = $service->price;
                    } else {
                        $kk = $service->price + ($service->price * $merchant->tax / 100);
                        $rex->amount = $service->price;
                        $rex->total = $kk - ($kk * $coupon->amount / 100);
                        $rex->tax = $service->price * $merchant->tax / 100;
                        $rex->coupon = $kk * $coupon->amount / 100;
                    }
                    $rex->coupon_code = $request->coupon_code;
                } else {
                    $rex->amount = $service->price;
                    $rex->total = $service->price + ($service->price * $merchant->tax / 100);
                    $rex->tax = $service->price * $merchant->tax / 100;
                    $rex->coupon = $service->price * $merchant->tax / 100;
                }
                $duration = ($service->duration > 1) ? str_plural($service->durationType) : $service->durationType;
                $rex->d_time = $request->time;
                $rex->d_date = $request->appointment_date;
                $rex->duration = $service->duration . ' ' . $duration;
                $rex->service_id = $service->id;
                $rex->store_id = $merchant->id;
                $rex->ref_id = $xtoken;
                $rex->user_id = $up_mer->id;
                $rex->currency = $currency->coin_id;
                $rex->payment_method = $request->action;
                $rex->status = 0;
                $rex->save();

                $sav = new Transactions();
                $sav->ref_id = $xtoken;
                $sav->type = 10;
                $sav->amount = $total;
                $sav->email = Auth::guard('customer')->user()->email;
                $sav->first_name = Auth::guard('customer')->user()->first_name;
                $sav->last_name = Auth::guard('customer')->user()->last_name;
                $sav->ip_address = user_ip();
                $sav->receiver_id = $merchant->user_id;
                $sav->payment_type = $request->action;
                $sav->currency = $currency->coin_id;
                $sav->track_no = $track;
                $sav->paid = 1;
                $sav->payment_link = $rex->id;
                $sav->mode = 1;
                $sav->status = 0;
                $sav->save();
                if ($request->action == 'bank') {
                    $authToken = base64_encode($currency->auth_key . ':' . $currency->auth_secret);
                    $curl = new Curl();
                    $curl->setHeader('Authorization', 'Basic ' . $authToken);
                    $curl->setHeader('Content-Type', 'application/json');
                    $curl->get("https://api.yapily.com/institutions");
                    $response = $curl->response;
                    $curl->close();
                    if ($curl->error) {
                        return back()->with('warning', $response->error->status . '-' . $response->error->message);
                    } else {
                        Cache::put('trans', $xtoken);
                        $data['authtoken'] = $authToken;
                        $data['institution'] = $response->data;
                        $data['title'] = 'Select Preferred Bank';
                        $data['type'] = 8;
                        $data['reference'] = $xtoken;
                        return view('user.dashboard.institution', $data);
                    }
                } elseif ($request->action == 'coinbase') {
                    $data = [
                        'name' => $merchant->store_name,
                        'description' => $merchant->store_name . ' Service Booking',
                        'pricing_type' => 'fixed_price',
                        'metadata' => array('customer_id' => $sav->ref_id, 'customer_name' => $sav->first_name . ' ' . $sav->last_name),
                        'local_price' => array('amount' => $sav->amount, 'currency' => $currency->coin->name),
                        'redirect_url' => route('coinbasesuccess', ['id' => $sav->ref_id]),
                        'cancel_url' => route('coinbasecancelled', ['id' => $sav->ref_id])
                    ];
                    $curl = new Curl();
                    $curl->setHeader('X-CC-Api-Key', $up_mer->coinbase_api_key);
                    $curl->setHeader('X-CC-Version', '2018-03-22');
                    $curl->setHeader('Content-Type', 'application/json');
                    $curl->post("https://api.commerce.coinbase.com/charges", $data);
                    $response = $curl->response;
                    $curl->close();
                    if ($curl->error) {
                        return back()->with('warning', $response->error->message);
                    } else {
                        $sav->charge_id = $response->data->code;
                        $sav->save();
                        return Redirect::away($response->data->hosted_url);
                    }
                } elseif ($request->action == 'paypal') {
                    $authToken = base64_encode($up_mer->paypal_client_id . ':' . $up_mer->paypal_secret_key);
                    $data = [
                        'intent' => "CAPTURE",
                        "purchase_units" => [
                            [
                                "amount" => [
                                    "currency_code" => $currency->coin->name,
                                    "value" => number_format($sav->amount, 2, '.', '')
                                ],
                            ]
                        ],
                        "application_context" => [
                            'return_url' => route('paypalsuccess', ['id' => $sav->ref_id]),
                            'cancel_url' => route('paypalcancelled', ['id' => $sav->ref_id])
                        ]
                    ];
                    $curl = new Curl();
                    $curl->setHeader('Authorization', 'Basic ' . $authToken);
                    $curl->setHeader('Content-Type', 'application/json');
                    $curl->post("https://api-m.paypal.com/v2/checkout/orders", $data);
                    $response = $curl->response;
                    $curl->close();
                    if ($curl->error) {
                        return back()->with('warning', $response->message);
                    } else {
                        $sav->charge_id = $response->id;
                        $sav->save();
                        return Redirect::away($response->links[1]->href);
                    }
                }
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('Merchant have exceeded the number of transactions he/she can perform this month');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Amount Exceeds Merchant Subscription Payment Limit');
        }
    }
    public function checkcoupon(Request $request, $id)
    {
        $cart = Cart::whereuniqueid($id)->first();
        $store = Storefront::whereid($cart->store)->firstOrFail();
        $allsum = Cart::whereuniqueid($id)->sum('total');
        if (Coupon::wherecode($request->code)->whereuser_id($store->user_id)->count() > 0) {
            $coupon = Coupon::wherecode($request->code)->whereuser_id($store->user_id)->first();
            if ($coupon->limits != 0) {
                if ($coupon->type == 1) {
                    if ($allsum > $coupon->amount || $allsum == $coupon->amount) {
                        return redirect()->route('user.sask', ['id' => getStorefrontCartFirst($store->id)->uniqueid, 'store_url' => $store->store_url, 'coupon' => $request->code])->with('success', 'Coupon Applied');
                    } else {
                        return back()->with('warning', 'Invalid Coupon!');
                    }
                } else {
                    return redirect()->route('user.sask', ['id' => getStorefrontCartFirst($store->id)->uniqueid, 'store_url' => $store->store_url, 'coupon' => $request->code])->with('success', 'Coupon Applied');
                }
            } else {
                return back()->with('warning', 'Invalid Coupon!');
            }
        } else {
            return back()->with('warning', 'Invalid Coupon!');
        }
    }
    public function updatecheckout(Request $request)
    {
        foreach ($request->uniqueid as $key => $val) {
            $cart = Cart::whereid($val)->first();
            $cart->total = $request->quantity[$key] * $request->cost[$key];
            $cart->cost = $request->cost[$key];
            $cart->quantity = $request->quantity[$key];
            $cart->save();
        }
        return back()->with('success', 'Cart updated');
    }

    public function deletecart($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return back()->with('success', 'Product successfully deleted from cart');
    }
    public function deletewishlist($id)
    {
        $wish = Wishlist::whereid($id)->wherecustomer_id(Auth::guard('customer')->user()->id)->first();
        $wish->delete();
        return back()->with('success', 'Product successfully deleted from wishlist');
    }
    public function submitcustomerlogin(Request $request)
    {
        $store = Storefront::whereid($request->store_id)->first();
        $customer = Storefrontcustomer::wherestore_id($request->store_id)->whereemail($request->email)->count();
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $remember_me = $request->has('remember_me') ? true : false;
        if ($customer == 1) {
            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
                Session::put('store_url', $store->store_url);
                if (session('return_url')) {
                    return redirect()->to(session('return_url'));
                } else {
                    return redirect()->route('website.link', ['id' => $store->store_url]);
                }
            }
        } else {
            return back()->with('warning', 'Invalid credentials');
        }
    }
    public function customerlogin($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $data['title'] = $store->store_name;
            return view('user.product.theme.' . $store->theme_id . '.account.store-login', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }

    public function submitcustomerregister(Request $request)
    {
        $store = Storefront::whereid($request->store_id)->first();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        try {
            $validatorf = new EmailValidator();
            $multipleValidations = new MultipleValidationWithAnd([
                new RFCValidation(),
                new DNSCheckValidation()
            ]);
            if ($validatorf->isValid($request->email, $multipleValidations)) {
            } else {
                return back()->with('warning', 'Invalid email address');
            }
            $check_phone = Storefrontcustomer::wherereal_phone($request->phone)->wherestore_id($store->id)->count();
            if ($check_phone > 0) {
                return back()->with('warning', 'Phone number has already been used');
            }
            $check_email = Storefrontcustomer::whereemail($request->email)->wherestore_id($store->id)->count();
            if ($check_email > 0) {
                return back()->with('warning', 'Email has already been used');
            }
            $verify_code = strtoupper(Str::random(32));
            $phone = PhoneNumber::make($request->phone, $store->user->getCountry()->iso)->formatE164();
            $user = new Storefrontcustomer();
            $user->first_name = ucwords(strtolower($request->first_name));
            $user->last_name = ucwords(strtolower($request->last_name));
            $user->phone = $phone;
            $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->verify_code = $verify_code;
            $user->iso = $store->user->getCountry()->iso;
            $user->real_phone = $request->phone;
            $user->store_id = $store->id;
            $user->save();
        } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
            return back()->with('warning', $e->getMessage());
        } catch (\Propaganistas\LaravelPhone\Exceptions\NumberFormatException $e) {
            return back()->with('warning', $e->getMessage());
        } catch (\Propaganistas\LaravelPhone\Exceptions\InvalidParameterException $e) {
            return back()->with('warning', $e->getMessage());
        } catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $e) {
            return back()->with('warning', $e->getMessage());
        }
        if ($this->settings->email_verification == 1) {
            $data = [
                'email' => $user->email,
                'name' => $user->first_name . ' ' . $user->last_name,
                'subject' => 'We need to verify your email address',
                'message' => 'Thanks you for signing up to ' . $store->store_name . '.<br> As part of our securtiy checks we need to verify your email address. Simply click on the link below and job done.<br><a href=' . route('customer.confirm-emailVcode', ['id' => $verify_code]) . '>' . route('customer.confirm-emailVcode', ['id' => $verify_code]) . '</a>'
            ];
            Mail::to($data['email'], $data['name'])->queue(new StorefrontEmail($data['subject'], $data['message'], $store));
        }
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password,])) {
            if (session::has('uniqueid')) {
                return redirect()->route('user.sask', ['id' => $request->cart, 'store_url' => $store->store_url]);
            } else {
                return redirect()->route('website.link', ['id' => $store->store_url]);
            }
        }
    }
    public function customerregister($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['unique'] = getStorefrontCartFirst($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $data['title'] = $store->store_name;
            return view('user.product.theme.' . $store->theme_id . '.account.store-register', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function customeroption($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        if ($store->user->status == 0) {
            if (Session::has('uniqueid')) {
                $data['cart'] = $all = getStorefrontCart($store->id);
                if (count($all) > 0) {
                    $data['unique'] = getStorefrontCartFirst($store->id);
                    $data['gtotal'] = getStorefrontCartTotal($store->id);
                    $data['merchant'] = getStorefrontOwner($store->user_id);
                    $data['title'] = $store->store_name;
                    return view('user.product.theme.' . $store->theme_id . '.account.store-option', $data);
                } else {
                    return redirect()->route('website.link', ['id' => $store->store_url])->with('warning', 'Cart is empty');
                }
            } else {
                return redirect()->route('website.link', ['id' => $store->store_url])->with('warning', 'Cart is empty');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function customeraddressstate(Request $request)
    {
        $ee = explode('*', $request->state);
        if (Auth::guard('customer')->check()) {
            if (!empty($ee[0])) {
                if ($request->state != null) {
                    if (Session::has('city')) {
                        $city = Shipcity::wherestate_code($ee[2])->where('id', '!=', session('city'))->orderby('name', 'asc')->get();
                        $getCity = Shipcity::whereid(session('city'))->first();
                        echo "<option value='$getCity->id' selected>$getCity->name</option>";
                        foreach ($city as $val) {
                            echo "<option value='$val->id'>$val->name</option>";
                        }
                    } else {
                        $city = Shipcity::wherestate_code($ee[2])->orderby('name', 'asc')->get();
                        if (count($city) > 0) {
                            echo "<option value=''>Select your city</option>";
                        }
                        foreach ($city as $val) {
                            echo "<option value='$val->id'>$val->name</option>";
                        }
                    }
                }
            }
        } else {
            if (!empty($ee[1])) {
                $city = Shipcity::wherestate_code($ee[3])->orderby('name', 'asc')->get();
                if ($request->state != null) {
                    foreach ($city as $val) {
                        echo "<option value='$val->name'>$val->name</option>";
                    }
                }
            }
        }
    }
    public function useraddressstate(Request $request)
    {
        $state = explode('*', $request->state);
        if ($state[1] != null) {
            $city = Shipcity::wherestate_code($state[1])->orderby('name', 'asc')->get();
            if (count($city) > 0) {
                echo "<option value=''>Select your city</option>";
            }
            foreach ($city as $val) {
                echo "<option value='$val->id'>$val->name</option>";
            }
        }
    }
    public function useraddressstatef(Request $request)
    {
        $state = Shipstate::whereid($request->state)->first();
        $city = Shipcity::wherestate_code($state->iso2)->orderby('name', 'asc')->get();
        $city2 = Shipcity::whereid($request->city)->first();
        if (count($city) > 0) {
            echo "<option value=''>Select your city</option>";
        }
        echo "<option value='$city2->id' selected>$city2->name</option>";
        foreach ($city as $val) {
            echo "<option value='$val->id'>$val->name</option>";
        }
    }
    public function useraddresscountry(Request $request)
    {
        $dd = Shipcountry::whereid($request->country)->first();
        $state = Shipstate::wherecountry_code($dd->iso2)->orderby('name', 'asc')->get();
        $state = County::where('country_id',$request->country)->orderby('name', 'asc')->get();
        return response()->json($state);
    }
    public function useraddresscountryf(Request $request)
    {
        $dd = Shipcountry::whereid($request->country)->first();
        $state = Shipstate::wherecountry_code($dd->iso2)->orderby('name', 'asc')->get();
        $state2 = Shipstate::whereid($request->state)->first();
        if (count($state) > 0) {
            echo "<option value=''>Select your state</option>";
        }
        echo "<option value='$state2->id*$state2->iso2' selected>$state2->name</option>";
        foreach ($state as $val) {
            echo "<option value='$val->id*$val->iso2'>$val->name</option>";
        }
    }
    public function emptycart($id, $store_url)
    {
        $cart = Cart::whereuniqueid($id)->get();
        foreach ($cart as $val) {
            $val->delete();
        }
        return redirect()->route('website.link', ['id' => $store_url])->with('success', 'Cart has been emptied');
    }
    public function customerorder($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['unique'] = getStorefrontCartFirst($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $data['order'] = Order::wherecustomer_id(Auth::guard('customer')->user()->id)->wherestore_id($store->id)->wherestatus(1)->orderby('id', 'desc')->get();
            $data['title'] = 'Orders';
            return view('user.product.theme.' . $store->theme_id . '.account.store-order', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function customerbookings($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['unique'] = getStorefrontCartFirst($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $data['order'] = Bookings::wherecustomer_id(Auth::guard('customer')->user()->id)->wherestore_id($store->id)->wherestatus(1)->orderby('d_date', 'desc')->get();
            $data['title'] = 'Orders';
            return view('user.product.theme.' . $store->theme_id . '.account.store-booking', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function customeraccount($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['unique'] = getStorefrontCartFirst($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $data['customer'] = Storefrontcustomer::whereid(Auth::guard('customer')->user()->id)->first();
            $data['title'] = $store->store_name;
            return view('user.product.theme.' . $store->theme_id . '.account.store-account', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function customeraccountupdate(Request $request, $store_url)
    {
        $store = Storefront::whereid($request->store_id)->first();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:customer',
        ]);
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        try {
            $result = explode("-", $request->code);
            $phone = PhoneNumber::make($request->phone, $store->user->getCountry()->iso)->formatE164();
            $user = Storefrontcustomer::whereid($request->customer_id)->first();
            $user->first_name = ucwords(strtolower($request->first_name));
            $user->last_name = ucwords(strtolower($request->last_name));
            $user->phone = $phone;
            $user->iso = $store->user->getCountry()->iso;
            $user->real_phone = $request->phone;
            $user->save();
        } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
            return back()->with('warning', $e->getMessage());
        } catch (\Propaganistas\LaravelPhone\Exceptions\NumberFormatException $e) {
            return back()->with('warning', $e->getMessage());
        } catch (\Propaganistas\LaravelPhone\Exceptions\InvalidParameterException $e) {
            return back()->with('warning', $e->getMessage());
        } catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $e) {
            return back()->with('warning', $e->getMessage());
        }
        return back()->with('success', 'Profile updated');
    }
    public function productreview(Request $request)
    {
        $order = Order::whereid($request->id)->first();
        $store = Storefront::whereid($order->store_id)->first();
        $order->rating = $request->rating;
        $order->review = $request->review;
        $order->save();
        if ($this->settings->email_notify == 1) {
            $data = [
                'email' => $store->user->email,
                'name' => $store->user->first_name . ' ' . $store->user->last_name,
                'subject' => $order->product->name . ' Review',
                'message' => "You just received a product review from a customer <br> Rating: " . $request->rating . " star<br> Review: " . $request->review
            ];
            Mail::to($data['email'], $data['name'])->queue(new SendEmail($data['subject'], $data['message']));
        }
        return back()->with('success', 'Review has been posted');
    }
    public function bookingreview(Request $request)
    {
        $order = Bookings::whereid($request->id)->first();
        $store = Storefront::whereid($order->store_id)->first();
        $order->rating = $request->rating;
        $order->review = $request->review;
        $order->save();
        if ($this->settings->email_notify == 1) {
            $data = [
                'email' => $store->user->email,
                'name' => $store->user->first_name . ' ' . $store->user->last_name,
                'subject' => $order->service->name . ' Review',
                'message' => "You just received a service review from a customer <br> Rating: " . $request->rating . " star<br> Review: " . $request->review
            ];
            Mail::to($data['email'], $data['name'])->queue(new SendEmail($data['subject'], $data['message']));
        }
        return back()->with('success', 'Review has been posted');
    }
    public function customersecurity($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['unique'] = getStorefrontCartFirst($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $data['customer'] = Storefrontcustomer::whereid(Auth::guard('customer')->user()->id)->first();
            $data['title'] = $store->store_name;
            return view('user.product.theme.' . $store->theme_id . '.account.store-security', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function customersecurityupdate(Request $request, $store_url)
    {
        $user = Storefrontcustomer::whereid($request->customer_id)->first();
        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return back()->with('success', 'Password Changed successfully.');
        } elseif (!Hash::check($request->password, $user->password)) {
            return back()->with('warning', 'Invalid password');
        }
    }
    public function customerorderstatus($store_url, $id)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = $merchant = getStorefrontOwner($store->user_id);
        $data['val'] = Order::wherecustomer_id(Auth::guard('customer')->user()->id)->whereid($id)->wherestore_id($store->id)->wherestatus(1)->first();
        $data['title'] = 'Order Details';
        return view('user.product.theme.' . $store->theme_id . '.account.store-order-status', $data);
    }
    public function customerbookingstatus($store_url, $id)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = $merchant = getStorefrontOwner($store->user_id);
        $data['val'] = Bookings::wherecustomer_id(Auth::guard('customer')->user()->id)->whereid($id)->wherestore_id($store->id)->wherestatus(1)->first();
        $data['title'] = 'Order Details';
        return view('user.product.theme.' . $store->theme_id . '.account.store-booking-status', $data);
    }
    public function customeraddress($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['unique'] = getStorefrontCartFirst($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $data['address'] = Storefrontaddress::wherecustomer_id(Auth::guard('customer')->user()->id)->orderby('id', 'desc')->get();
            $data['title'] = $store->store_name;
            return view('user.product.theme.' . $store->theme_id . '.account.store-address', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function customeraddressadd($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['unique'] = getStorefrontCartFirst($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = $merchant = getStorefrontOwner($store->user_id);
            $data['title'] = $store->store_name;
            $data['shipping'] = Shipping::whereuser_id($store->user_id)->wherestatus(1)->latest()->get();
            return view('user.product.theme.' . $store->theme_id . '.account.store-address-add', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function customeraddressedit($store_url, $id)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['unique'] = getStorefrontCartFirst($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $data['address'] = $address = Storefrontaddress::whereid($id)->first();
            Session::put('city', $address->city);
            $data['title'] = $store->store_name;
            $data['shipping'] = Shipping::whereuser_id($store->user_id)->wherestatus(1)->latest()->get();
            return view('user.product.theme.' . $store->theme_id . '.account.store-address-edit', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function customeraddresssave(Request $request)
    {
        $ee = explode('*', $request->state);
        $store = Storefront::whereid($request->store_id)->first();
        $data = new Storefrontaddress();
        $data->shipping_id = $ee[1];
        $data->state = $ee[0];
        $data->city = $request->city;
        $data->postal_code = $request->postal_code;
        $data->line_1 = $request->line_1;
        $data->line_2 = $request->line_2;
        $data->customer_id = Auth::guard('customer')->user()->id;
        $data->save();
        return redirect()->route('customer.address', ['store_url' => $store->store_url])->with('success', 'Address added');
    }
    public function customeraddressupdate(Request $request)
    {
        $ee = explode('*', $request->state);
        $store = Storefront::whereid($request->store_id)->first();
        $data = Storefrontaddress::whereid($request->id)->first();
        $data->shipping_id = $ee[1];
        $data->state = $ee[0];
        $data->city = $request->city;
        $data->postal_code = $request->postal_code;
        $data->line_1 = $request->line_1;
        $data->line_2 = $request->line_2;
        $data->customer_id = Auth::guard('customer')->user()->id;
        $data->save();
        return redirect()->route('customer.address', ['store_url' => $store->store_url])->with('success', 'Address updated');
    }
    public function customeraddressdelete($store_url, $id)
    {
        $data = Storefrontaddress::whereid($id)->first();
        $data->delete();
        return back()->with('success', 'Address deleted');
    }
    public function logout($store_url)
    {
        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
            return redirect()->route('website.link', ['id' => $store_url])->with('warning', 'Just Logged Out!');
        } else {
            return back();
        }
    }

}
