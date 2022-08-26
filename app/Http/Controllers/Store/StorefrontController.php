<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Productimage;
use App\Models\Settings;
use App\Models\Shipping;
use App\Models\Storefront;
use App\Models\Storefrontaddress;
use App\Models\Storefrontcustomer;
use App\Models\Storereview;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StorefrontController extends Controller
{
    public function storefront($store_url){
        $data['store'] = $store = getStorefront($store_url);
        $data['title'] = $store->store_name;
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.view-store', $data);    
    }

    public function productlink($store, $product)
    {
        $data['store'] = $store = Storefront::wherestore_url($store)->firstorFail();
        $data['product'] = $product = Product::whereref_id($product)->firstOrFail();
        $data['reviews'] = Storereview::wherestore_id($store->id)->get();
        $product->views = $product->views + 1;
        $product->save();
        $data['image'] = Productimage::whereproduct_id($product->id)->get();
        $data['title'] = $product->name;
        $data['store'] = $store;
        $data['related'] = Product::wherecat_id($product->cat_id)->take(4)->get();
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.view-product', $data);
    }

    public function searchstorelink(Request $request, $id)
    {
        $data['store'] = $store = getStorefront($id);
        $data['cart'] = getStorefrontCart($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = getStorefrontOwner($store->user_id);
        $data['products'] = Product::whereuser_id($store->user_id)->where('cat_id', '!=', 0)->where('description', 'LIKE', '%' . $request->search . '%')->orWhere('name', 'LIKE', '%' . $request->search . '%')->orWhere('tags', 'LIKE', '%' . $request->search . '%')->orderby('id', 'desc')->paginate($store->product_per_page);
        $data['title'] = $store->store_name;
        $data['category'] = getProductCategory();
        // Session::put('search', );
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.view-store-search', $data)->with('search',$request->search); 
    }

    public function customerregister($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = getStorefrontOwner($store->user_id);
        $data['title'] = $store->store_name;
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.store-register', $data);  
    }

    public function customerlogin($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = getStorefrontOwner($store->user_id);
        $data['title'] = $store->store_name;
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.store-login', $data);
    }

    public function trackorder($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = getStorefrontOwner($store->user_id);
        $data['title'] = $store->store_name;
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.store-track', $data);
    }

    public function trackorderstatus($store_url, $orderid)
    {   
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = getStorefrontOwner($store->user_id);
        $data['val'] = Order::where('ref_id',$orderid)->whereseller_id($store->user_id)->wherestatus(1)->get();
        $data['title'] = 'Order Details';
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.store-order-status-offline', $data);
    }

    public function submittrackorder(Request $request, $store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = getStorefrontOwner($store->user_id); 
        $key = Order::where('ref_id',$request->order_id)->whereseller_id($store->user_id)->wherestatus(1)->count();
        if ($key > 0) {
            $data['val'] = Order::where('ref_id',$request->order_id)->whereseller_id($store->user_id)->wherestatus(1)->get();
            $data['title'] = 'Orders Details';
            return view('user.product.storefront.theme.' . $store->store_theme_id . '.store-order-status-offline', $data);
        } else {
            return back()->with('warning', 'Invalid Tracking number');
        }
     
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
                return redirect()->route('store.index', ['id' => $store->store_url]);
            }
        } else {
            return back()->with('warning', 'Invalid credentials');
        }
    }

    public function customerwishlistadd($store_url, $id)
    {
        $check = Wishlist::wherecustomer_id(Auth::guard('customer')->user()->id)->whereproduct_id($id)->count();
        if ($check == 0) {
            $store = Storefront::wherestore_url($store_url)->first();
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

    public function customeraccount($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = getStorefrontOwner($store->user_id);
        $data['customer'] = Storefrontcustomer::whereid(Auth::guard('customer')->user()->id)->first();
        $data['title'] = $store->store_name;
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.store-account', $data);
    }

    public function customerorder($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = getStorefrontOwner($store->user_id);
        $data['order'] = Order::wherecustomer_id(Auth::guard('customer')->user()->id)->wherestore_id($store->id)->wherestatus(1)->orderby('id', 'desc')->get();
        $data['title'] = 'Orders';
        return view('user.product.storefront.theme.' . $store->store_theme_id .'.store-order', $data);
    }

    public function customerwishlist($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = getStorefrontOwner($store->user_id);
        $data['wishlist'] = Wishlist::wherecustomer_id(Auth::guard('customer')->user()->id)->wherestore_id($store->id)->orderby('id', 'desc')->paginate(10);
        $data['title'] = $store->store_name;
        return view('user.product.storefront.theme.' . $store->store_theme_id .'.store-wishlist', $data);
    
    }

    public function deletewishlist($id,$wishlistId)
    {
    
        $wish = Wishlist::whereid($wishlistId)->wherecustomer_id(Auth::guard('customer')->user()->id)->first();
        $wish->delete();
        return back()->with('success', 'Product successfully deleted from wishlist');
    }


    public function customeraddress($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = getStorefrontOwner($store->user_id);
        $data['address'] = Storefrontaddress::wherecustomer_id(Auth::guard('customer')->user()->id)->orderby('id', 'desc')->with('states')->get();
        $data['title'] = $store->store_name;
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.store-address', $data);
    }

    public function customeraddressadd($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = $merchant = getStorefrontOwner($store->user_id);
        $data['title'] = $store->store_name;
        $data['shipping'] = Shipping::whereuser_id($store->user_id)->wherestatus(1)->latest()->get();
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.store-address-add', $data);
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
        return redirect()->route('store.customer.address', ['id' => $store->store_url])->with('success', 'Address added');
    }

    public function customersecurity($store_url)
    {
        $data['store'] = $store = Storefront::wherestore_url($store_url)->first();
        $data['cart'] = getStorefrontCart($store->id);
        $data['unique'] = getStorefrontCartFirst($store->id);
        $data['gtotal'] = getStorefrontCartTotal($store->id);
        $data['merchant'] = getStorefrontOwner($store->user_id);
        $data['customer'] = Storefrontcustomer::whereid(Auth::guard('customer')->user()->id)->first();
        $data['title'] = $store->store_name;
        return view('user.product.storefront.theme.' . $store->store_theme_id . '.store-security', $data); 
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

    public function sask($store_url,$id, $coupon = null)
    {

        $data['store'] = $store = Storefront::wherestore_url($store_url)->firstOrFail();
        $set = Settings::where('id',1)->first();
        if ($set->store == 1) {
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
                                            return redirect()->route('store.customer.address', ['id' => $store->store_url])->with('warning', 'Add and address for checkout');
                                        } else {
                                            $data['address'] = Storefrontaddress::wherecustomer_id(Auth::guard('customer')->user()->id)->get();
                                            return view('user.product.storefront.theme.' . $store->store_theme_id . '.checkout', $data);
                                        }
                                    } else {
                                        $data['shipping'] = Shipping::whereuser_id($store->user_id)->wherestatus(1)->latest()->get();
                                        return view('user.product.storefront.theme.' . $store->store_theme_id .'.checkout_guest', $data);
                                    }
                                } else {
                                    return redirect()->route('store.index', ['id' => $store->store_url])->with('warning', 'No item in cart');
                                }
                            } else {
                                $data['shipping'] = Shipping::whereuser_id($store->user_id)->wherestatus(1)->latest()->get();
                                return view('user.product.storefront.theme.' . $store->store_theme_id .'.checkout_guest', $data);
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

    public function logout($store_url)
    {
        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
            return redirect()->route('store.index', ['id' => $store_url])->with('warning', 'Just Logged Out!');
        } else {
            return back();
        }
    }
}
