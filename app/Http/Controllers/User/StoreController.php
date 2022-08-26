<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;
use App\Models\Settings;
use App\Models\Order;
use App\Models\Bookings;
use App\Models\Audit;
use App\Models\HomepageSettings;
use App\Models\Storefront;
use App\Models\Storefrontcustomer;
use App\Models\Transactions;
use App\Models\Customdomain;
use App\Models\Menu;
use Propaganistas\LaravelPhone\PhoneNumber;
use Image;
use Illuminate\Support\Facades\Session;
use App\Mail\StorefrontEmail;
use App\Jobs\SendStoreReceipt;
use App\Jobs\SendWithCustomDomainDrivers;
use App\Models\CustomMailDriver;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->settings = Settings::find(1);
    }
    public function reschedule($id)
    {
        return view('user.product.reschedule', ['title' => 'Reschedule', 'booking' => Bookings::find($id)]);
    }    
    public function updateschedule(Request $request, $id)
    {
        $book = Bookings::find($id);
        $book->d_date=$request->appointment_date;
        $book->d_time=$request->time;
        $book->save();
        return redirect()->route('user.appointment.pending')->with('toast_success', "Schedule updated");
    }
    public function checkBusiness(Request $request)
    {   
        if(Storefront::wherestore_url($request->storeUrl)->count()==0){
            return response()->json(['st' => 1]);
        }else{
            return response()->json(['st' => 2]);
        }
    }
    public function getCalendar(Request $request, $id)
    {
        $schedule_model = Storefront::wherestore_url($id)->first();
        $working_time_arr = $days_of_week_disable = $vacation_arr = array();
        $week_arr['sun'] = 0;
        $week_arr['mon'] = 1;
        $week_arr['tue'] = 2;
        $week_arr['wed'] = 3;
        $week_arr['thu'] = 4;
        $week_arr['fri'] = 5;
        $week_arr['sat'] = 6;
        if (!empty($schedule_model)) {
            if (!empty($schedule_model->working_time)) {
                $working_time_arr = $schedule_model->working_time;
                if (!empty($working_time_arr)) {
                    foreach ($working_time_arr as $key => $value) {
                        if ($value['status'] == 0) {
                            $days_of_week_disable[] = $week_arr[$key];
                        }
                    }
                }
            }
            if (!empty($schedule_model->vacation_time)) {
                $vacation_arr = $schedule_model->vacation_time;
            }
        }
        $vacation_time_arr = (!empty($vacation_arr)) ? $vacation_arr : array();
        $return_data['days_of_week_disable']   = $days_of_week_disable;
        $return_data['vacation_time_arr']      = $vacation_time_arr;
        return response()->json($return_data);
    }
    public function getAvailableTime(Request $request, $id)
    {
        $date = substr($request->date, 0, strpos($request->date, '00:00'));
        $appointment_date = date('Y-m-d', strtotime($date));
        $date_weekday = $request->date_weekday;
        $schedule_model = Storefront::wherestore_url($id)->first();
        if (!empty($schedule_model->working_time)) {
            $working_time_arr = $schedule_model->working_time;
            if (!empty($working_time_arr)) {
                $week_arr[0] = 'sun';
                $week_arr[1] = 'mon';
                $week_arr[2] = 'tue';
                $week_arr[3] = 'wed';
                $week_arr[4] = 'thu';
                $week_arr[5] = 'fri';
                $week_arr[6] = 'sat';
                $day_schedule_working = $working_time_arr[$week_arr[$date_weekday]];
                $available_time_arr = array();
                foreach(getTimeIntervalByTime($day_schedule_working['start'], $day_schedule_working['end'], 30) as $val){
                    $available_time_arr[] = $val;
                }
                $data_arr['appointment_date'] = $appointment_date;
                $data_arr['available_time_arr'] = $available_time_arr;
                return response()->json($data_arr);
            }
        }
    }
    public function ecommerce()
    {
        return view('user.product.ecommerce', ['title' => 'Ecommerce']);
    }
    public function websiteTheme()
    {
        return view('user.product.settings.theme', ['title' => 'Template']);
    }
    public function websiteCoupon()
    {
        return view('user.product.settings.coupon', ['title' => 'Coupons']);
    }
    public function websiteInstruction()
    {
        return view('user.product.settings.custom_domain', ['title' => 'Connect domain']);
    }
    public function websiteBlog()
    {
        return view('user.product.settings.blog', ['title' => 'News & Articles']);
    }
    public function websiteFaq()
    {
        return view('user.product.settings.faq', ['title' => 'Frequently asked questions']);
    }
    public function websiteReview()
    {
        return view('user.product.settings.review', ['title' => 'Reviews']);
    }
    public function websiteTeam()
    {
        return view('user.product.settings.team', ['title' => 'Teams']);
    }
    public function websiteBrand()
    {
        return view('user.product.settings.brand', ['title' => 'Brands']);
    }
    public function websitePage()
    {
        return view('user.product.settings.page', ['title' => 'Custom Page']);
    }
    public function appointment()
    {
        return view('user.product.appointment', ['title' => 'Appointment']);
    }
    public function customers()
    {
        return view('user.product.customers', ['title' => 'Customers']);
    }
    public function confirmEmailVcode($id)
    {

        $key = Storefrontcustomer::whereverify_code($id)->count();
        if ($key == 0) {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invalid Token');
        } else {
            $user = Storefrontcustomer::whereverify_code($id)->first();
            if ($user->email_verify == 1) {
                $data['title'] = 'Email Verification';
                return view('user.merchant.success', $data)->withErrors('Email has already been verified');
            } else {
                $user->email_verify = 1;
                $user->save();
                $data['title'] = 'Email Verification';
                return view('user.merchant.success', $data)->withErrors('Your email was verified successfully');
            }
        }
    }
    public function storefront()
    {
        return view('user.product.settings.index', ['title' => 'Settings']);
    }
    public function createStore()
    {
        $xf = auth()->guard('user')->user()->getCountrySupported();
        if ($this->settings->store == 1) {
            if($xf->store == 1) {
                if (count(auth()->guard('user')->user()->storefrontCount()) == 1) {
                    return back()->with('warning', 'You already have a storefront');
                }
                $data['title'] = 'Create Storefront';
                return view('user.product.create_website', $data);
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('Storefront is not available for your country');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Storefront is currently unavailable');
        }
    }
    public function newproduct()
    {

        $xf = auth()->guard('user')->user()->getCountrySupported();
        if ($this->settings->store == 1) {
            if ($xf->store == 1) {
                if (count(auth()->guard('user')->user()->storefrontCount()) == 0) {
                    return back()->with('warning', 'You need to have a website');
                }
                $data['title'] = 'Create Product';
                return view('user.product.store.create_product', $data);
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('Website is not available for your country');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Website is currently unavailable');
        }
    }
    public function submitstore(Request $request)
    {
        session::put('store_name', $request->store_name);
        session::put('store_desc', $request->store_desc);
        session::put('store_url', $request->store_url);
        $num = Storefront::whereuser_id(Auth::guard('user')->user()->id)->count();
        if ($num == 0) {
            $check = Storefront::wherestore_name(strtolower($request->store_name))->count();
            if ($check > 0) {
                return back()->with('warning', 'Website name already taken!');
            } else {
                $check = Storefront::wherestore_url($request->store_url)->count();
                if ($check == 0) {
                    $data = new Storefront();
                    $data->user_id = Auth::guard('user')->user()->id;
                    $data->store_name = $request->store_name;
                    $data->store_desc = $request->store_desc;
                    $data->store_url = $request->store_url;
                    $data->save();
                    $menu = new Menu();
                    $menu->store_id=$data->id;
                    $menu->menus=Storefront::menu();
                    $menu->save();
                    $website = new HomepageSettings();
                    $website->store_id=$data->id;
                    $website->user_id=Auth::guard('user')->user()->id;
                    if(array_key_exists('slider', Storefront::template(1)['home_page'])){
                        $website->slider_status=Storefront::template(1)['home_page']['slider']['status'];
                        $website->slider_limit=Storefront::template(1)['home_page']['slider']['limit'];
                    }
                    if(array_key_exists('blog', Storefront::template(1)['home_page'])){
                        $website->blog_status=Storefront::template(1)['home_page']['blog']['status'];
                        $website->blog_limit=Storefront::template(1)['home_page']['blog']['limit'];
                        $website->blog_title=Storefront::template(1)['home_page']['blog']['title'];
                        $website->blog_body=Storefront::template(1)['home_page']['blog']['body']; 
                    }  
                    if(array_key_exists('review', Storefront::template(1)['home_page'])){  
                        $website->review_status=Storefront::template(1)['home_page']['review']['status'];
                        $website->review_limit=Storefront::template(1)['home_page']['review']['limit'];
                        $website->review_title=Storefront::template(1)['home_page']['review']['title'];
                        $website->review_body=Storefront::template(1)['home_page']['review']['body'];
                    }     
                    if(array_key_exists('services', Storefront::template(1)['home_page'])){
                        $website->services_status=Storefront::template(1)['home_page']['services']['status'];
                        $website->services_limit=Storefront::template(1)['home_page']['services']['limit'];
                        $website->services_title=Storefront::template(1)['home_page']['services']['title'];
                        $website->services_body=Storefront::template(1)['home_page']['services']['body'];
                    }    
                    if(array_key_exists('team', Storefront::template(1)['home_page'])){    
                        $website->team_status=Storefront::template(1)['home_page']['team']['status'];
                        $website->team_limit=Storefront::template(1)['home_page']['team']['limit'];
                        $website->team_title=Storefront::template(1)['home_page']['team']['title'];
                        $website->team_body=Storefront::template(1)['home_page']['team']['body'];
                    } 
                    if(array_key_exists('statistics', Storefront::template(1)['home_page'])){
                        $website->statistics_status=Storefront::template(1)['home_page']['statistics']['status'];
                        $website->statistics_limit=Storefront::template(1)['home_page']['statistics']['limit'];
                        $website->statistics_title=Storefront::template(1)['home_page']['statistics']['title'];
                        $website->statistics_body=Storefront::template(1)['home_page']['statistics']['body'];
                    }
                    $website->save();
                    return redirect()->route('user.storefront')->with('toast_success', 'Website succesfully created');
                } else {
                    return back()->with('toast_warning', 'URL slug not available');
                }
            }
        } else {
            return redirect()->route('user.storefront')->with('toast_warning', 'You can\'t have more than one website');
        }
    }
    public function editstore(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'product_per_page' => 'required|in:8,16,32,64',
            'display_related_products' =>'boolean',
            'product_review' => 'boolean',
            'storeActive' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $user = User::find(Auth::user()->id);
        $store = Storefront::find($user->storefront()->id);
        $store->product_per_page = $request->product_per_page;
        $store->display_related_products = $request->display_related_products;
        $store->product_review = $request->product_review;
        $store->display_category = $request->display_category;
        $store->storeActive = ($request->storeActive == false OR $request->storeActive == NULL) ? 0 : 1;
        $store->save();
        return back()->with('toast_success', 'Ecommerce setting updated!');
    }
    public function editwebsite(Request $request)
    {
        $user = User::findOrFail(Auth::guard('user')->user()->id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            if ($user->image != 'person.png') {
                $path = public_path('asset/profile/');
                File::delete($path . $user->image);
            }
            Image::make($image)->save($location);
            $user->image = $filename;
            $user->save();
        }
        $store = Storefront::find(auth()->guard('user')->user()->storefront()->id);
        $store->display_blog = $request->display_blog;
        $store->meta_keywords = $request->meta_keywords;
        $store->store_name = $request->store_name;
        $store->store_desc = $request->store_desc;
        $store->meta_description = $request->meta_description;
        $store->analytics = $request->analytics;
        $store->facebook_pixel = $request->facebook_pixel;
        $store->tax = $request->tax;
        $store->status = $request->status;
        $store->save();
        if (!empty($request->checkout_logo)) {
            if ($user->image != null) {
                $user->checkout_logo = $request->checkout_logo;
                $user->save();
            } else {
                return back()->with('toast_warning', 'No website logo found, please upload a check out image');
            }
        } else {
            $user->checkout_logo = $request->checkout_logo;
            $user->save();
        }
        $store->save();
        return back()->with('toast_success', 'Website succesfully updated');
    }
    public function editbooking(Request $request)
    {
        $store = Storefront::find(auth()->guard('user')->user()->storefront()->id);
        $store->service_type = $request->service_type;
        $store->session_time = $request->session_time;
        $store->booking_per_day = $request->booking_per_day;
        $store->service_review = $request->service_review;
        $state = explode('*', $request->state);
        if ($request->service_type == 2) {
            $validator = Validator::make($request->all(), [
                'state' => 'required',
                'line_1' => 'required',
                'postal_code' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('errors', $validator->errors());
            }
            $store->state = $state[0];
            $store->city = $request->city;
            $store->line_1 = $request->line_1;
            $store->postal_code = $request->postal_code;
        }
        if($request->has('booking_setup')){
            $store->working_time=Storefront::working_hour();
            $store->save();
        }
        if (!empty($request->workingtime)) {
            if (!empty($request->workingtime['mon']['status'])) {
                $mon = $store->working_time;
                $mon['mon'] = $request->workingtime['mon'];
                $mon['mon']['status'] = 1;
                $store->working_time = $mon;
                $store->save();
            } else {
                $mon = $store->working_time;
                $mon['mon']['status'] = 0;
                $store->working_time = $mon;
                $store->save();
            }
            if (!empty($request->workingtime['tue']['status'])) {
                $tue = $store->working_time;
                $tue['tue'] = $request->workingtime['tue'];
                $tue['tue']['status'] = 1;
                $store->working_time = $tue;
                $store->save();
            } else {
                $tue = $store->working_time;
                $tue['tue']['status'] = 0;
                $store->working_time = $tue;
                $store->save();
            }
            if (!empty($request->workingtime['wed']['status'])) {
                $wed = $store->working_time;
                $wed['wed'] = $request->workingtime['wed'];
                $wed['wed']['status'] = 1;
                $store->working_time = $wed;
                $store->save();
            } else {
                $wed = $store->working_time;
                $wed['wed']['status'] = 0;
                $store->working_time = $wed;
                $store->save();
            }
            if (!empty($request->workingtime['thu']['status'])) {
                $thu = $store->working_time;
                $thu['thu'] = $request->workingtime['thu'];
                $thu['thu']['status'] = 1;
                $store->working_time = $thu;
                $store->save();
            } else {
                $thu = $store->working_time;
                $thu['thu']['status'] = 0;
                $store->working_time = $thu;
                $store->save();
            }
            if (!empty($request->workingtime['fri']['status'])) {
                $fri = $store->working_time;
                $fri['fri'] = $request->workingtime['fri'];
                $fri['fri']['status'] = 1;
                $store->working_time = $fri;
                $store->save();
            } else {
                $fri = $store->working_time;
                $fri['fri']['status'] = 0;
                $store->working_time = $fri;
                $store->save();
            }
            if (!empty($request->workingtime['sat']['status'])) {
                $sat = $store->working_time;
                $sat['sat'] = $request->workingtime['sat'];
                $sat['sat']['status'] = 1;
                $store->working_time = $sat;
                $store->save();
            } else {
                $sat = $store->working_time;
                $sat['sat']['status'] = 0;
                $store->working_time = $sat;
                $store->save();
            }
            if (!empty($request->workingtime['sun']['status'])) {
                $sun = $store->working_time;
                $sun['sun'] = $request->workingtime['sun'];
                $sun['sun']['status'] = 1;
                $store->working_time = $sun;
                $store->save();
            } else {
                $sun = $store->working_time;
                $sun['sun']['status'] = 0;
                $store->working_time = $sun;
                $store->save();
            }
        } else {
            return back()->with('toast_warning', 'Please select a business hour');
        }
        if (!empty($request->customva)) {
            $store->vacation_status = 1;
            $vacation = explode('-', $request->date);
            $store->vacation_time = [
                'startdate' => $vacation[0],
                'enddate' => $vacation[1],
            ];
        } else {
            $store->vacation_status = 0;
        }
        $store->save();
        return back()->with('toast_success', 'Booking settings updated!');
    }
    public function editdomain(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'custom_domain' =>'required|url',
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        //Check if domain is with a user
        $storeUsingDomain = Customdomain::where('domain',$request->custom_domain)->first();

        if(!empty($storeUsingDomain) AND $storeUsingDomain->user_id != $id ){
            return back()->with('toast_warning', 'Custom domain has been taken by another user');
        }
        else if(!preg_match('#^http(s)://#', trim($request->custom_domain, '/'))) {
            return back()->with('toast_warning', 'Please add a domain name secured with ssl');
        }
        $urlParts = parse_url(trim($request->custom_domain, '/'));
        if ($urlParts['host'] == "tryba.io") {
            return back()->with('toast_warning', 'Cannot add tryba.io as custom domain');
        }

        //Add Domain to Cloudflare
        $response = Http::withHeaders([
            'X-Auth-Key' => env('TRYBA_CLOUDFLARE_API'),
            'X-Auth-Email' =>  env('TRYBA_CLOUDFLARE_EMAIL')
        ])->post(env('CLOUDFLARE_BASE_URL').'zones/'. env('TRYBA_CLOUDFLARE_ZONE_IDENTIFIER').'/custom_hostnames', [
            'hostname' => $urlParts['host'],
            'ssl' => [
                "method" => "http",
                "type" => "dv",
                "settings" => [
                  "http2" => "on",
                  "min_tls_version" => "1.2",
                  "tls_1_3" => "on",
                  "ciphers" => [
                    "ECDHE-RSA-AES128-GCM-SHA256",
                    "AES128-SHA"
                  ],
                  "early_hints" => "on"
                ],
                "bundle_method" => "ubiquitous",
                "wildcard" => false,
                "custom_certificate" => "",
                "custom_key" => ""
            ]
        ]);

        Customdomain::updateOrCreate(
            ['user_id' => Auth::user()->id],
            [
                'domain' => $request->custom_domain,
                'status' => true
            ]
        );
        
        return back()->with('toast_success', 'Custom domain updated');
    }

    public function disConnect($id){
        $customDomain = Customdomain::where('user_id',$id)->first();
        $customDomain->domain = NULL;
        $customDomain->save();

        return back()->with('toast_success', 'Custom domain disconnected');
    }

    public function editmail(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'mail_port' =>'required|numeric',
            'mail_username' =>'required|string',
            'mail_password' =>'required|string',
            'mail_encryption' =>'required|in:tls,ssl',
            'mail_from_address' => 'required|string',
            'mail_from_name' => 'required|string',
            'mail_host' => 'required|string',
            'status' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        CustomMailDriver::updateOrCreate([
           'user_id' => Auth::user()->id
        ],[
           'mail_driver' => $request->mail_driver,
           'mail_port' => $request->mail_port,
           'mail_username' => $request->mail_username,
           'mail_password' => $request->mail_password,
           'mail_encryption' => $request->mail_encryption,
           'mail_from_address' => $request->mail_from_address,
           'mail_from_name' => $request->mail_from_name,
           'mail_host' => $request->mail_host,
           'status' => $request->status
       ]);

        return back()->with('toast_success', 'Email configuration updated');
    }
    public function defaultTheme($id, $key)
    {
        $store = Storefront::findOrFail($id);
        $store->theme_id = $key;
        $store->save();
        return redirect()->route('theme.edit.store')->with('toast_success', 'Theme activated');
    }
    public function completeOrder($store_url, $id)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $order = Order::whereref_id($id)->wherestore_id($store->id)->first();
        if ($store->user->status == 0) {
            if ($order->first_name == null) {
                $data['cart'] = getStorefrontCart($store->id);
                $data['unique'] = getStorefrontCartFirst($store->id);
                $data['gtotal'] = getStorefrontCartTotal($store->id);
                $data['merchant'] = getStorefrontOwner($store->user_id);
                $data['order'] = $order;
                $data['title'] = 'Complete Order';
                $data['id'] = $id;
                return view('user.product.theme.' . $store->theme_id . '.complete_order', $data);
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.success', $data)->withErrors('Order already completed!!');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }
    public function submitCompleteOrder(Request $request, $id)
    {

        $data = Order::whereref_id($id)->first();
        $receiver = User::whereid($data->seller_id)->first();
        $transaction = Transactions::wheretrack_no($data->order_id)->first();
        try {
            $phone = PhoneNumber::make($request->phone, $data->seller->getCountry()->iso)->formatE164();
            $data->phone = $phone;
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->line_1 = $request->line_1;
            $data->line_2 = $request->line_2;
            $data->postal_code = $request->postal_code;
            $data->note = $request->note;
            $data->save();
            if ($this->settings->email_notify == 0) {
                dispatch(new SendStoreReceipt($data->ref_id, $transaction->payment_type, $data->order_id));
            }
            if ($receiver->receive_webhook == 1) {
                if ($receiver->webhook != null) {
                    send_webhook($transaction->id);
                }
            }
            $audit = new Audit();
            $audit->user_id = $receiver->id;
            $audit->trx = $id;
            $audit->log = 'Received payment ' . $id;
            $audit->save();
            return redirect()->route('website.receipt', ['store_url' => $data->storefront->store_url, 'id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
        } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
            return back()->with('warning', $e->getMessage());
        } catch (\Propaganistas\LaravelPhone\Exceptions\NumberFormatException $e) {
            return back()->with('warning', $e->getMessage());
        } catch (\Propaganistas\LaravelPhone\Exceptions\InvalidParameterException $e) {
            return back()->with('warning', $e->getMessage());
        } catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $e) {
            return back()->with('warning', $e->getMessage());
        }
    }
    public function orderstatus(Request $request, $id)
    {
        $this->settings = Settings::find(1);
        $order = Order::whereid($id)->first();
        $store = Storefront::whereid($order->store_id)->first();
        $order->order_status = $request->order_status;
        $order->save();
        if ($order->customer_id != null) {
            $first_name = $order->buyer->first_name;
            $last_name = $order->buyer->last_name;
            $email = $order->buyer->email;
        } else {
            $first_name = $order->first_name;
            $last_name = $order->last_name;
            $email = $order->email;
        }
        if ($this->settings->email_notify == 1) {
            $data = [
                'email' => $email,
                'name' => $first_name . ' ' . $last_name,
                'subject' => 'Order status - ' . $order->order_id,
                'message' => "Order status has been updated to " . $request->order_status . ". Thanks for choosing " . $order->storefront->store_name,
                'message2' => 'Kindly rate our service ' . $request->order_id . '.<br> We would appreciate if you can take your time and rate this product, <br><a href=' . route('customer.order.status', ['store_url' => $store->store_url, 'id' => $order->id]) . '>Click here</a> to do this'
            ];
            Mail::to($data['email'], $data['name'])->queue(new StorefrontEmail($data['subject'], $data['message'], $store));
            if ($request->order_status == "Delivered") {
                Mail::to($data['email'], $data['name'])->queue(new StorefrontEmail($data['subject'], $data['message2'], $store));
            }
        }
        return back()->with('toast_success', 'Order status has been updated');
    }
    public function customerorders($id)
    {

        $customer = Storefrontcustomer::find($id);
        $xf = auth()->guard('user')->user()->getCountrySupported();
        if ($this->settings->store == 1) {
            if ($xf->store == 1) {
                $data['orders'] = Order::wherecustomer_id($id)->wherestatus(1)->latest()->get();
                $data['title'] = $customer->first_name . ' ' . $customer->last_name . ' orders';
                return view('user.product.store.customer-orders', $data);
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('Website is not available for your country');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Website is currently unavailable');
        }
    }
    public function customersendemail($id)
    {

        $customer = Storefrontcustomer::find($id);
        $xf = auth()->guard('user')->user()->getCountrySupported();
        if ($this->settings->store == 1) {
            if ($xf->store == 1) {
                $data['title'] = 'Compose email';
                $data['val'] = $customer;
                return view('user.product.send_email', $data);
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('Website is not available for your country');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Website is currently unavailable');
        }
    }
    public function verifyDns(Request $request)
    {
        $urlParts = parse_url(trim($request->custom_domain, '/'));
        try {
            if (verifyNameServersValue($urlParts['host'])[0] == getNameServersValue()[0] && verifyNameServersValue($urlParts['host'])[1] == getNameServersValue()[1]) {
                return back()->with('toast_success', 'Great, domain is pointing to our name servers!');
            } else {
                return back()->with('toast_warning', 'Domain isn\'t pointed to our name servers!');
            }
        } catch (\Exception $e) {
            return back()->with('toast_warning', 'An error occured!');
        }
    }
    public function testEmail(Request $request, $id)
    {
        $store = Storefront::whereid($id)->first();
        if ($this->settings->email_verification == 1) {
            $data = [
                'email' => $request->email
            ];
            try {
                Mail::to($data['email'], 'Name')->send(new StorefrontEmail('Subject', 'Message', $store));
                return back()->with('toast_success', 'Email Sent!');
            } catch (\Exception $e) {
                return back()->with('toast_warning', 'An error occured!');
            }
        }
    }
    public function sendEmail(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' =>'required|email',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $user = User::where('id',Auth::user()->id)->firstorFail();

        if ($this->settings->email_verification == 1 AND $user->mailDriver != NULL) {
            $data = [
                'email' => $request->email,
                'name' => $user->mailDriver->mail_from_name,
                'address' => $user->mailDriver->mail_from_address,
                'subject' => 'Test Email',
                'message' => $request->message,
            ];
            try {
                dispatch_sync(new SendWithCustomDomainDrivers($user,$data));
                return  back()->with('toast_success', 'Email Sent!');
            } catch (\Exception $e) {
                Log::info($e);
                return back()->with('toast_warning', 'An error occured!');
            }
        }
        else{
            return back()->with('toast_warning', 'Update your email configuration');
        }
    }

    public function storefrontThemes(){
        $store = Storefront::where('user_id',Auth::user()->id)->first();
        
        return view('user.product.storefront.store.theme',[
            'store' => $store,
            'title' => 'Storefront Themes'
        ]);
    }
}
