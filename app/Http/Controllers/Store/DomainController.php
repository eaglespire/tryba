<?php

namespace App\Http\Controllers\Store;
use App\Events\RegDomainEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Registerdomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Settings;
use App\Models\Product;
use App\Models\Order;
use App\Models\Countrysupported;
use App\Models\Productimage;
use App\Models\Storefront;
use App\Models\Storefrontcustomer;
use App\Models\Storefrontaddress;
use App\Models\Shipping;
use App\Models\Shipcity;
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
use App\Mail\SendEmail;
use App\Models\Bookings;
use App\Models\BookingServices;
use App\Models\County;
use App\Models\CustomerPasswordReset;
use App\Models\Shipcountry;
use App\Models\Shipstate;
use Illuminate\Support\Facades\Mail;

class DomainController extends Controller
{
    public function __construct(Request $request)
    {
        $this->settings = Settings::find(1);
        $this->url = $request->getSchemeAndHttpHost();
    }

    public function storelink($type = null)
    {
        $data['store'] = $store = getStorefrontDomain($this->url);
        $data['title'] = $store->store_name;
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.view-store', $data);
    }
    public function storeArticles()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        $data['title'] = 'Articles';
        return view('user.product.theme.' . $store->theme_id . '.blog', $data);
    }
    public function storeTeam()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        $data['title'] = 'Team';
        return view('user.product.theme.' . $store->theme_id . '.team', $data);
    }
    public function storeReview()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        $data['title'] = 'Review';
        return view('user.product.theme.' . $store->theme_id . '.review', $data);
    }
    public function storeFaq()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        $data['title'] = 'Faq';
        $data['id'] = $store->store_url;
        return view('user.product.theme.' . $store->theme_id . '.faq', $data);
    }

    public function storeServices()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        $data['title'] = 'Services';
        return view('user.product.theme.' . $store->theme_id . '.book.services', $data);
    }
    public function storeBook($service, $coupon = null)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
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

    public function getCalendar(Request $request, $id)
    {
        $schedule_model = Storefront::wherecustom_domain($this->url)->first();
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

    public function getAvailableTime(Request $request)
    {
        $date = substr($request->date, 0, strpos($request->date, '00:00'));
        $appointment_date = date('Y-m-d', strtotime($date));
        $date_weekday = $request->date_weekday;
        $schedule_model = Storefront::wherecustom_domain($this->url)->first();
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

    public function storeProducts()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        $data['title'] = 'Products';
        return view('user.product.theme.' . $store->theme_id . '.products', $data);
    }

    public function storeBlogView($ref, $slug)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        $data['blog'] = $blog = Storeblog::whereid($ref)->first();
        $blog->views = $blog->views + 1;
        $blog->save();
        $data['title'] = $blog->title;
        return view('user.product.theme.' . $store->theme_id . '.article', $data);
    }

    public function storePageView( $ref, $slug)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        $data['page'] = $page = Storepages::whereid($ref)->first();
        $data['title'] = $page->title;
        return view('user.product.theme.' . $store->theme_id . '.page', $data);
    }

    public function searchstorelink(Request $request)
    {
      //  if ($store->user->status == 0) {
         //   if ($store->status == 1) {
                $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
                $data['cart'] = getStorefrontCart($store->id);
                $data['gtotal'] = getStorefrontCartTotal($store->id);
                $data['merchant'] = getStorefrontOwner($store->user_id);
                $data['products'] = Product::whereuser_id($store->user_id)->where('cat_id', '!=', 0)->where('description', 'LIKE', '%' . $request->search . '%')->orWhere('name', 'LIKE', '%' . $request->search . '%')->orWhere('tags', 'LIKE', '%' . $request->search . '%')->orderby('id', 'desc')->paginate($store->product_per_page);
                $data['title'] = $store->store_name;
                $data['category'] = getProductCategory();
              //  session::put('search', $request->search);
                return view('user.product.theme.' . $store->theme_id . '.search', $data)->with('search', $request->search);
            // } else {
            //     $data['title'] = 'Error Message';
            //     return view('user.merchant.no-store', $data);
            // }

        // } else {
        //     $data['title'] = 'Error Message';
        //     return view('user.merchant.error', $data)->withErrors('An Error Occured');
        // }
    }

    public function storecat($cat)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
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

    public function productlink($product)
    {
     //   if ($store->count() > 1 AND $store->status == 1) {
         //   if ($store->user->display_support_email == 1 && $store->user->display_support_phone == 1) {
                $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
                $data['product'] = $xproduct = Product::whereref_id($product)->firstOrFail();
                $xproduct->views = $xproduct->views + 1;
                $xproduct->save();
              //$data['image'] = $image = Productimage::whereproduct_id($xproduct->id)->get();
                $data['image'] =  Productimage::whereproduct_id($xproduct->id)->get();
                $data['title'] = $xproduct->name;
                $data['store'] = $store;
                //can be removed
                $data['related'] = Product::wherecat_id($xproduct->cat_id)->take(4)->get();
                //can be removed
                return view('user.product.theme.' . $store->theme_id . '.view-product', $data);

            // } else {
            //     $data['title'] = 'Error Message';
            //     return view('user.merchant.error', $data)->withErrors('Please setup your support information.');
            // }
       // }

        // else {
        //     $data['title'] = 'Error Message';
        //     return view('user.merchant.no-store', $data);
        // }
    }

    public function sask($id,$coupon = null)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        if ($this->settings->store == 1) {
            $data['product'] = Cart::whereuniqueid($id)->wherestore($store->id)->first();
            if ($coupon == null) {
                $allsum = $data['allsum'] = Cart::whereuniqueid($id)->sum('total');
                $data['coupon_status'] = 0;
            } else {
                if (Coupon::wherecode($coupon)->count() > 0) {
                    $data['coupon'] = $ddd = Coupon::wherecode($coupon)->first();
                    if ($ddd->type == 1) {
                        $data['coupon_amount'] = $ddd->amount;
                    } else {
                        $data['coupon_amount'] = Cart::whereuniqueid($id)->sum('total') * $ddd->amount / 100;
                    }
                    $data['allsum'] = $allsum = Cart::whereuniqueid($id)->sum('total') - $data['coupon_amount'];
                    $data['coupon_status'] = 1;
                } else {
                    $allsum = $data['allsum'] = Cart::whereuniqueid($id)->sum('total');
                }
            }
            $all = $data['all'] = Cart::whereuniqueid($id)->get();
            $data['merchant'] = $merchant = getStorefrontOwner($store->user_id);
            if (count($all) > 0) {
                if ($merchant->status == 0) {
                    if ($merchant->payment == 1) {
                        $data['title'] = 'Checkout';
                        $data['ref'] = 'ORD-' . str_random(6);
                        $data['ship'] = Shipping::whereuser_id($store->user_id)->get();
                        $data['country'] = Country::all();
                        $data['subtotal'] = $allsum;
                        $data['total'] = ($allsum * $store->tax / 100) + $allsum;
                        $data['cart'] = Cart::where('uniqueid', $id)->wherestore($store->id)->get();
                        $data['unique'] = Cart::where('uniqueid', $id)->wherestore($store->id)->first();
                        $data['gtotal'] = Cart::where('uniqueid', $id)->wherestore($store->id)->sum('total');
                        if ($merchant->bank_pay == 1 || $merchant->paypal == 1 || $merchant->coinbase == 1) {
                            if (Auth::guard('customer')->check()) {
                                if (count(getStorefrontCart($store->id)) > 0) {
                                    if ($store->id == Auth::guard('customer')->user()->store_id) {
                                        $addresscount = Storefrontaddress::wherecustomer_id(Auth::guard('customer')->user()->id)->wherestatus(1)->count();
                                        if ($addresscount == 0) {
                                            return redirect()->route('customer.address', ['store_url' => $store->store_url])->with('warning', 'Add and address for checkout');
                                        } else {
                                            $data['address'] = Storefrontaddress::wherecustomer_id(Auth::guard('customer')->user()->id)->get();
                                            return view('user.product.theme.' . $store->theme_id . '.checkout', $data);
                                        }
                                    } else {
                                        $data['shipping'] = Shipping::whereuser_id($store->user_id)->wherestatus(1)->latest()->get();
                                        return view('user.product.theme.' . $store->theme_id . '.checkout_guest', $data);
                                    }
                                } else {
                                    return redirect()->route('website.link', ['id' => $store->store_url])->with('warning', 'No item in cart');
                                }
                            } else {
                                $data['shipping'] = Shipping::whereuser_id($store->user_id)->wherestatus(1)->latest()->get();
                                return view('user.product.theme.' . $store->theme_id . '.checkout_guest', $data);
                            }
                        } else {
                            $data['title'] = 'Error';
                            return view('user.merchant.success', $data)->withErrors('Merchant has not selected any payment method');
                        }
                    } else {
                        $data['title'] = 'Error Message';
                        return view('user.merchant.error', $data)->withErrors('Merchant is not allowed to receive payment');
                    }
                } else {
                    $data['title'] = 'Error Message';
                    return view('user.merchant.error', $data)->withErrors('Merchant is not allowed to receive payment');
                }
            } else {
                return redirect()->route('website.link', ['id' => $store->store_url])->with('warning', 'Cart is empty');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Product is currently unavailable');
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
        }
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
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

    public function updatecart(Request $request)
    {
        if (empty(Session::get('uniqueid'))) {
            $product = Product::whereid($request->product)->first();
            if ($product->color != null) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'color' => 'required'
                    ],
                    [
                        'color.required' => 'Please select color',
                    ]
                );
                if ($validator->fails()) {
                    return back()->with('errors', $validator->errors());
                }
            }
            if ($product->size != null) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'size' => 'required'
                    ],
                    [
                        'size.required' => 'Please select size',
                    ]
                );
                if ($validator->fails()) {
                    return back()->with('errors', $validator->errors());
                }
            }
            if ($product->length != null) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'length' => 'required'
                    ],
                    [
                        'length.required' => 'Please select length',
                    ]
                );
                if ($validator->fails()) {
                    return back()->with('errors', $validator->errors());
                }
            }
            if ($product->weight != null) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'weight' => 'required'
                    ],
                    [
                        'weight.required' => 'Please select weight',
                    ]
                );
                if ($validator->fails()) {
                    return back()->with('errors', $validator->errors());
                }
            }
            $cart = new Cart();
            $cart->uniqueid = $request->uniqueid;
            $cart->product = $request->product;
            $cart->title = $request->title;
            $cart->quantity = $request->quantity;
            $cart->cost = $request->cost;
            $cart->store = $request->store;
            $cart->size = $request->size;
            $cart->color = $request->color;
            $cart->length = $request->length;
            $cart->weight = $request->weight;
            $cart->total = $request->quantity * $request->cost;
            Session::put('uniqueid', $request->uniqueid);
            $cart->save();
        } else {
            $cart = Cart::whereuniqueid($request->uniqueid)->whereproduct($request->product)->first();
            $check = Cart::whereuniqueid($request->uniqueid)->whereproduct($request->product)->count();
            if ($check > 0) {
                $data =  $request->all();
                $cart->update($data);
                $cart->total = $request->quantity * $request->cost;
                $cart->save();
            } else {
                $cart = new Cart;
                $cart->fill($request->all());
                $cart->save();
                $cart->total = $request->quantity * $request->cost;
                $cart->save();
            }
        }
        return back()->with('success', 'Added to cart');
    }
    public function customershowLinkRequestForm()
    {
        $data['title'] = "Forgot password";
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        $data['merchant']=$merchant=User::whereid($store->user_id)->first();
        return view('user.product.theme.' . $store->theme_id . '.account.customer-email', $data);
    }

    public function customersendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $store = Storefront::wherestore_id($request->store_id)->first();
        $check = Storefrontcustomer::whereEmail($request->email)->wherestore_id($request->store_id)->count();
        if ($check==0){
            return back()->with('toast_success', 'If an account was found to '.$request->email.', you will receive a password reset link.');
        }else{
            $user = Storefrontcustomer::whereEmail($request->email)->wherestore_id($request->store_id)->first();
            $to =$user->email;
            $name = $user->name;
            $subject = 'Password Reset';
            $code = str_random(30);
            $link = url('/customer-password/').'/reset/'.$code.'/'.$store->store_name;
            DB::table('customer_password_resets')->insert(
                ['email' => $to, 'token' => $code,  'created_at' => date("Y-m-d h:i:s")]
            );
            $gg=[
                'email'=>$to,
                'name'=>$name,
                'subject'=>$subject,
                'message'=>"Use This Link to Reset Password: <br> <a href='" . $link . "'>" . $link . "</a>"
            ];
            Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
            return back()->with('toast_success', 'If an account was found to '.$request->email.', you will receive a password reset link.');
        }
    }

    public function customershowResetForm($token)
    {
        $data['title'] = "Change Password";
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
         $tk =CustomerPasswordReset::where('token',$token)->first();
         if(is_null($tk))
         {
            $notification =  array('message' => 'Token Not Found!!','alert-type' => 'warning');
            return redirect()->route('customer.password.request')->with($notification);
         }else{
            $email = $tk->email;
            return view('user.product.theme.' . $store->theme_id . '.account.customer-reset', $data)->with(['token' => $token, 'email' => $email]);
         }
    }

    public function customerreset(Request $request)
    {
        $tk =CustomerPasswordReset::where('token', $request->token)->first();
        $user = Storefrontcustomer::whereEmail($tk->email)->first();
        if(!$user)
        {
            return back()->with('toast_warning', 'Email do not match!!');
        }else{
            $user->password = bcrypt($request->password);
            $user->save();
            return back()->with('toast_success', 'Successfully Password Reset.');
        }
    }

    public function submitcustomerlogin(Request $request)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
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

    public function submittrackorder(Request $request)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['unique'] = getStorefrontCartFirst($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $key = Order::whereorder_id($request->order_id)->wherestore_id($store->id)->wherestatus(1)->orderby('id', 'desc')->count();
            if ($key > 0) {
                $data['order'] = Order::whereorder_id($request->order_id)->wherestore_id($store->id)->wherestatus(1)->orderby('id', 'desc')->get();
                $data['title'] = 'Orders';
                return view('user.product.theme.' . $store->theme_id . '.account.store-order-offline', $data);
            } else {
                return back()->with('warning', 'Invalid Tracking number');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }

    public function customerlogin()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
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

    public function generatereceipt($id){
        $data['link']=$trans=Transactions::whereref_id($id)->first();
        if($trans->status==1){
            $data['title']="Receipt from ".$trans->receiver->first_name.' '.$trans->receiver->last_name;
            $data['trans']=$trans;
            $data['merchant']=User::find($trans->receiver_id);
            return view('user.transactions.receipt', $data);
        }else{
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }

    public function trackorder()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $data['title'] = $store->store_name;
            return view('user.product.theme.' . $store->theme_id . '.account.store-track', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }

    public function trackorderstatus($id)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['unique'] = getStorefrontCartFirst($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = $merchant = getStorefrontOwner($store->user_id);
            $data['val'] = Order::whereid($id)->wherestore_id($store->id)->wherestatus(1)->first();
            $data['title'] = 'Order Details';
            return view('user.product.theme.' . $store->theme_id . '.account.store-order-status-offline', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }

    public function submitcustomerregister(Registerdomain $request)
    {

        $store = Storefront::whereid($request->store_id)->first();

        // $validator = Validator::make($request->all(), [
        //     'first_name' => 'required|string|max:255',
        //     'last_name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255',
        //     'phone' => 'required|string',
        //     'password' => 'required|string|min:6',
        // ]);
        // if ($validator->fails()) {
        //     return back()->with('errors', $validator->errors());
        // }
        // try {
            // $validatorf = new EmailValidator();
            // $multipleValidations = new MultipleValidationWithAnd([
            //     new RFCValidation(),
            //     new DNSCheckValidation()
            // ]);
            // if ($validatorf->isValid($request->email, $multipleValidations)) {
            // } else {
            //     return back()->with('warning', 'Invalid email address');
            // }
            // $check_phone = Storefrontcustomer::wherereal_phone($request->phone)->wherestore_id($store->id)->count();
            // if ($check_phone > 0) {
            //     return back()->with('warning', 'Phone number has already been used');
            // }
            // $check_email = Storefrontcustomer::whereemail($request->email)->wherestore_id($store->id)->count();
            // if ($check_email > 0) {
            //     return back()->with('warning', 'Email has already been used');
            // }
            $verify_code = strtoupper(Str::random(32));
            $phone = PhoneNumber::make($request->phone, $store->user->getCountry()->iso)->formatE164();
            // $user = new Storefrontcustomer();
            // $user->first_name = ucwords(strtolower($request->first_name));
            // $user->last_name = ucwords(strtolower($request->last_name));
            // $user->phone = $phone;
            // $user->password = Hash::make($request->password);
            // $user->email = $request->email;
            // $user->verify_code = $verify_code;
            // $user->iso = $store->user->getCountry()->iso;
            // $user->real_phone = $request->phone;
            // $user->store_id = $store->id;
            // $user->save();
         $user = Storefrontcustomer::create([
            "first_name" => ucwords(strtolower($request->first_name)),
            "last_name" => ucwords(strtolower($request->last_name)),
            "phone" => $phone,
            "password" => Hash::make($request->password),
            "email" => $request->email,
            "verify_code" => $verify_code,
            "iso" => $store->user->getCountry()->iso,
            "real_phone" => $request->phone,
             "store_id" => $store->id,
            ]);
        // } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
        //     return back()->with('warning', $e->getMessage());
        // } catch (\Propaganistas\LaravelPhone\Exceptions\NumberFormatException $e) {
        //     return back()->with('warning', $e->getMessage());
        // } catch (\Propaganistas\LaravelPhone\Exceptions\InvalidParameterException $e) {
        //     return back()->with('warning', $e->getMessage());
        // } catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $e) {
        //     return back()->with('warning', $e->getMessage());
        // }
        if ($this->settings->email_verification == 1) {
            $data = [
                'email' => $user->email,
                'name' => $user->first_name . ' ' . $user->last_name,
                'subject' => 'We need to verify your email address',
                'message' => 'Thanks you for signing up to ' . $store->store_name . '.<br> As part of our securtiy checks we need to verify your email address. Simply click on the link below and job done.<br><a href=' . route('customer.confirm-emailVcode', ['id' => $verify_code]) . '>' . route('customer.confirm-emailVcode', ['id' => $verify_code]) . '</a>'
            ];
          //  Mail::to($data['email'], $data['name'])->queue(new StorefrontEmail($data['subject'], $data['message'], $store));
          //
             $name = $user->first_name . ' ' . $user->last_name;
             $subject = 'We need to verify your email address';
             $message = 'Thanks you for signing up to ' . $store->store_name . '.<br> As part of our securtiy checks we need to verify your email address. Simply click on the link below and job done.<br><a href=' . route('customer.confirm-emailVcode', ['id' => $verify_code]) . '>' . route('customer.confirm-emailVcode', ['id' => $verify_code]) . '</a>';
             event(new RegDomainEvent($user->email, $name, $subject, $message, $store));
        }
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password,])) {
            if (session::has('uniqueid')) {
                return redirect()->route('user.sask', ['id' => $request->cart, 'store_url' => $store->store_url]);
            } else {
                return redirect()->route('website.link', ['id' => $store->store_url]);
            }
        }
    }
    public function customerregister()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
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

    public function customeroption()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->first();
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

    public function emptycart($id)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
        $cart = Cart::whereuniqueid($id)->get();
        foreach ($cart as $val) {
            $val->delete();
        }
        return redirect()->route('website.link', ['id' => $store->store_url])->with('success', 'Cart has been emptied');
    }

    public function customerwishlistadd($id)
    {
        $check = Wishlist::wherecustomer_id(Auth::guard('customer')->user()->id)->whereproduct_id($id)->count();
        if ($check == 0) {
            $store = Storefront::wherecustom_domain($this->url)->firstorFail();
            $data = new Wishlist();
            $data->product_id = $id;
            $data->store_id = $store->id;
            $data->customer_id = Auth::guard('customer')->user()->id;
            $data->save();
            return back()->with('success', 'Added to wishlist');
        } else {
            return back()->with('warning', 'Already added to wishlist');
        }
    }

    public function customerwishlist()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
        if ($store->user->status == 0) {
            $data['cart'] = getStorefrontCart($store->id);
            $data['unique'] = getStorefrontCartFirst($store->id);
            $data['gtotal'] = getStorefrontCartTotal($store->id);
            $data['merchant'] = getStorefrontOwner($store->user_id);
            $data['wishlist'] = Wishlist::wherecustomer_id(Auth::guard('customer')->user()->id)->wherestore_id($store->id)->orderby('id', 'desc')->paginate(10);
            $data['title'] = $store->store_name;
            return view('user.product.theme.' . $store->theme_id . '.account.store-wishlist', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }


    public function customerorder()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
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

    public function customerbookings()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
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

    public function customeraccount()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
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


    public function customeraccountupdate(Request $request)
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

    public function customersecurity()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
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

    public function customersecurityupdate(Request $request)
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

    public function customerorderstatus($id)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = $merchant = getStorefrontOwner($store->user_id);
        $data['val'] = Order::wherecustomer_id(Auth::guard('customer')->user()->id)->whereid($id)->wherestore_id($store->id)->wherestatus(1)->first();
        $data['title'] = 'Order Details';
        return view('user.product.theme.' . $store->theme_id . '.account.store-order-status', $data);
    }
    public function customerbookingstatus($id)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = $merchant = getStorefrontOwner($store->user_id);
        $data['val'] = Bookings::wherecustomer_id(Auth::guard('customer')->user()->id)->whereid($id)->wherestore_id($store->id)->wherestatus(1)->first();
        $data['title'] = 'Order Details';
        return view('user.product.theme.' . $store->theme_id . '.account.store-booking-status', $data);
    }

    public function customeraddress()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
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

    public function customeraddressadd()
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
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

    public function customeraddressedit($id)
    {
        $data['store'] = $store = Storefront::wherecustom_domain($this->url)->firstorFail();
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

    public function customeraddressdelete($id)
    {
        $data = Storefrontaddress::whereid($id)->first();
        $data->delete();
        return back()->with('success', 'Address deleted');
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

    public function logout()
    {
        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
            $store = Storefront::wherecustom_domain($this->url)->firstorFail();
            return redirect()->route('website.link', ['id' => $store->store_url])->with('warning', 'Just Logged Out!');
        } else {
            return back();
        }
    }


}
