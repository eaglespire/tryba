<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Countrysupported;
use App\Models\Shipping;
use App\Models\Storefrontcustomer;
use App\Models\Storefrontaddress;
use App\Models\Shipcountry;
use App\Models\Shipstate;
use App\Models\Coupon;



class ShippingController extends Controller
{
    public function submitShipping(Request $request)
    {
        $currency = Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if (Auth::guard('user')->user()->live == 0) {
            $mode = 0;
        } else {
            $mode = 1;
        }
        $sav['user_id'] = Auth::guard('user')->user()->id;
        $sav['state'] = $request->state;
        $sav['amount'] = $request->amount;
        $sav['currency'] = $currency->coin_id;
        $sav['mode'] = $mode;
        Shipping::create($sav);
        return redirect()->route('user.shipping')->with('toast_success', 'Shipping fee added!');
    }
    public function editShipping(Request $request)
    {
        $ship = Shipping::find($request->id);
        $ship->state = $request->state;
        $ship->amount = $request->amount;
        $ship->status = $request->status;
        if ($request->status == 0) {
            $pre = Storefrontaddress::whereshipping_id($ship->id)->get();
            foreach ($pre as $val) {
                $val->status = 0;
                $val->save();
            }
        }
        $ship->save();
        return redirect()->route('user.shipping')->with('toast_success', 'Shipping Region succesfully updated');
    }
    public function destroyShipping($id)
    {
        $check = Shipping::whereuser_id(Auth::guard('user')->user()->id)->count();
        if ($check == 1) {
            return redirect()->route('user.shipping')->with('toast_warning', 'There must be 1 shipping region');
        } elseif ($check > 1) {
            $pre = Storefrontaddress::whereshipping_id($id)->get();
            if (count($pre) > 0) {
                return redirect()->route('user.shipping')->with('toast_warning', 'You can\'t delete this shipping region because you have customers registered with this address, we recommend you disable this shipping address & we will inform customers that this shipping address has been disabled');
            } else {
                $data = Shipping::findOrFail($id);
                $data->delete();
                return redirect()->route('user.shipping')->with('toast_success', 'Shipping Region succesfully deleted');
            }
        }
    }
    public function destroyCoupon($id)
    {
        $data = Coupon::findOrFail($id);
        $data->delete();
        return back()->with('toast_success', 'Coupon deleted');
    }
    public function submitCoupon(Request $request)
    {
        if (Coupon::wherecode($request->code)->whereuser_id(Auth::guard('user')->user()->id)->count() == 0) {
            $data = new Coupon();
            $data->user_id = Auth::guard('user')->user()->id;
            $data->name = $request->name;
            $data->limits = $request->limits;
            $data->code = $request->code;
            $data->type = $request->type;
            if ($request->type == 1) {
                $data->amount = $request->fiat_amount;
            } else {
                $data->amount = $request->percent_amount;
            }
            $data->save();
            return back()->with('toast_success', 'Coupon created');
        } else {
            return back()->with('toast_warning', 'Coupon code already used!');
        }
    }    
    public function editCoupon(Request $request, $id)
    {
        if (Coupon::wherecode($request->code)->whereuser_id(Auth::guard('user')->user()->id)->where('id', '!=', $id)->count() == 0) {
            $data = Coupon::whereid($id)->first();
            $data->name = $request->name;
            $data->limits = $request->limits;
            $data->code = $request->code;
            $data->type = $request->type;
            if ($request->type == 1) {
                $data->amount = $request->fiat_amount;
            } else {
                $data->amount = $request->percent_amount;
            }
            $data->save();
            return redirect()->route('user.store.coupon')->with('toast_success', 'Coupon updated');
        } else {
            return back()->with('toast_warning', '2 coupons can\'t have the same code!');
        }
    }
    public function updateCoupon($id)
    {
        $data['title'] = 'Edit Coupon';
        $data['val'] = Coupon::findOrFail($id);
        return view('user.product.settings.edit_coupon', $data);
    }
}
