<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Product;
use App\Models\Productimage;
use App\Models\Order;
use App\Models\Countrysupported;
use App\Models\Productcategory;
use App\Models\Storefront;
use App\Models\Shipping;
use App\Models\Cart;
use App\Models\Fundcategory;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Session;
use Image;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    //Product
    public function product()
    {
        $set = Settings::first();
        if (Auth::guard('user')->user()->live == 0) {
            $mode = 0;
        } else {
            $mode = 1;
        }
        $xf = Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if ($set->store == 1) {
            if ($xf->store == 1) {
                $data['title'] = 'Products';
                $data['product'] = Product::whereUser_id(Auth::guard('user')->user()->id)->wheremode($mode)->orderby('id', 'desc')->get();
                $data['category'] = Productcategory::whereUser_id(Auth::guard('user')->user()->id)->wheremode($mode)->get();
                $data['received'] = Order::whereStatus(1)->whereseller_id(Auth::guard('user')->user()->id)->wheremode($mode)->sum('total');
                $data['total'] = Order::whereseller_id(Auth::guard('user')->user()->id)->wheremode($mode)->sum('total');
                $data['shipping'] = Shipping::whereuser_id(Auth::guard('user')->user()->id)->wheremode($mode)->latest()->get();
                return view('user.product.index', $data);
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('Store is not available for your country');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Store is currently unavailable');
        }
    }
    public function Destroyproduct($id)
    {
        $data = Product::findOrFail($id);
        $image = Productimage::whereproduct_id($id)->get();
        $order = Order::whereproduct_id($id)->get();
        $cart = Cart::whereproduct($id)->get();
        $data->delete();
        return redirect()->route('user.product')->with('toast_success', 'Product succesfully deleted');
    }
    public function Destroyproductcategory($id)
    {
        $data = ProductCategory::findOrFail($id);
        $cat = Product::wherecat_id($id)->count();
        if ($cat > 0) {
            return back()->with('toast_warning', 'Category cannot be deleted as it is assigned to a product');
        } else {
            $data->delete();
            return redirect()->route('user.product')->with('toast_success', 'Category succesfully deleted');
        }
    }
    public function submitproduct(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'images' => 'required|max:2000'
            ],
            [
                'images.max' => 'Image size must be lower than 2mb',
            ]
        );
        if ($validator->fails()) {
            return back()->withInput()->with('errors', $validator->errors());
        }
        $mode = (Auth::guard('user')->user()->live == 0)  ? 0 : 1;
        $currency = Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();

        $data = new Product();
        $data->user_id = Auth::guard('user')->user()->id;
        $data->ref_id = 'PRD-' . str_random(6);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->details = $request->details;
        $data->specification = $request->specification;
        $data->quantity = $request->quantity;
        $data->cat_id = $request->category;
        $data->amount = $request->amount;
        $data->new = 1;
        $data->currency = $currency->coin_id;
        $data->mode = $mode;
        $data->tags = $request->tags;
        $data->size = $request->size;
        $data->length = $request->length;
        $data->length_unit = $request->length_unit;
        $data->weight = $request->weight;
        $data->weight_unit = $request->weight_unit;
        $data->discount = $request->discount;
        $data->featured = $request->featured;
        $data->save();
        foreach ($request->color as $val) {
            $color[] = $val;
            $data->color = $color;
        }
        $data->save();
        foreach ($request->file('images') as $file) {
            $sa = new Productimage();
            $sa->image = Cloudinary::uploadFile($file->getRealPath())->getSecurePath();
            $sa->product_id = $data->id;
            $sa->save();
        }
        return redirect()->route('user.product')->with('toast_success', 'Product successfully created');

    }
    public function productlink($store, $product)
    {
        $data['product'] = $xproduct = Product::whereid($product)->first();
        $data['rr'] = $rr = Productimage::whereproduct_id($product)->first();
        $data['image'] = $image = Productimage::whereproduct_id($product)->get();
        $data['store'] = $store = Storefront::whereid($store)->first();
        $data['merchant'] = $merchant = User::whereid($store->user_id)->first();
        $data['cart'] = Cart::where('uniqueid', Session::get('uniqueid'))->wherestore($store->id)->get();
        $data['gtotal'] = Cart::where('uniqueid', Session::get('uniqueid'))->wherestore($store->id)->sum('total');
        $data['title'] = $xproduct->name;
        return view('user.product.view-product', $data);
    }
    public function submitproductimage(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|max:2000'
            ],
            [
                'file.max' => 'Image size must be lowere than 2mb',
            ]
        );
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $check = Productimage::whereproduct_id($request->id)->count();
        if ($check < 6) {
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $sav['image'] = Cloudinary::uploadFile($image->getRealPath())->getSecurePath();
                $sav['product_id'] = $request->id;
                Productimage::create($sav);
                $ext = Product::whereid($request->id)->first();
                $ext->new = 1;
                $ext->save();
                return back()->with('toast_success', 'Successfully uploaded');
            } else {
                return back()->with('toast_warning', 'An error occured, please try again later');
            }
        } else {
            return back()->with('toast_warning', 'You have exceeded your image limit');
        }
    }
    public function deleteproductimage($id)
    {
        $data = Productimage::findOrFail($id);
        $ext = Productimage::whereproduct_id($data->product_id)->count();
        if ($ext == 1) {
            $dext = Product::whereid($data->product_id)->first();
            $dext->new = 0;
            $dext->save();
        }
        File::delete(public_path('asset/profile/' . $data->image));
        $data->delete();
        return back()->with('toast_success', 'Image Deleted Successfully!');
    }
    public function Descriptionupdate(Request $request)
    {
        $data = Product::whereId($request->id)->first();
        $data->fill($request->all())->save();
        return back()->with('toast_success', 'Successfully updated');
    }
    public function Featureupdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'description' => 'required'
            ]
        );
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $data = Product::whereId($request->id)->first();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->details = $request->details;
        $data->specification = $request->specification;
        $data->tags = $request->tags;
        $data->size = $request->size;
        $data->length = $request->length;
        $data->length_unit = $request->length_unit;
        $data->weight = $request->weight;
        $data->weight_unit = $request->weight_unit;
        $data->discount = $request->discount;
        $data->cat_id = $request->cat_id;
        $data->amount = $request->amount;
        $data->quantity = $request->quantity;
        $data->status = $request->status;
        $data->featured = $request->featured;
        $data->save();
        if ($request->color != null) {
            foreach ($request->color as $val) {
                $color[] = $val;
                $data->color = $color;
            }
        }
        if ($request->file('old') != null) {
            foreach ($request->file('old') as $key => $file) {
                $kk = Productimage::whereid($request->pid[$key])->first();
                $old[]=$kk->id;
                if ($request->changed[$key] == 1) {
                    $sa = Productimage::whereid($request->pid[$key])->first();
                    File::delete(public_path('asset/profile/' . $sa->image));
                    $sa->image = Cloudinary::uploadFile($file->getRealPath())->getSecurePath();
                    $sa->save();
                }
            }
        }
        if ($request->pid != null) {
            $pp = Productimage::whereproduct_id($request->id)->get();
            foreach ($request->pid as $key => $file) {
                $new[]=$file;
            }
            foreach ($pp as $key => $val) {
                if(in_array($val->id, $new)){

                }else{
                    File::delete(public_path('asset/profile/' . $val->image));
                    $val->delete();
                }
            }
        }
        if ($request->file('images') != null) {
            foreach ($request->file('images') as $file) {               
                $sa = new Productimage();
                $sa->image = Cloudinary::uploadFile($file->getRealPath())->getSecurePath();
                $sa->product_id = $data->id;
                $sa->save();
            }
        }
        $data->save();
        $check = Shipping::whereuser_id(Auth::guard('user')->user()->id)->count();
        if ($check > 0) {
            if (empty($request->shipping_status)) {
                $data->shipping_status = 0;
            } else {
                $data->shipping_status = $request->shipping_status;
            }
            $data->save();
        } else {
            return back()->with('toast_warning', 'Ensure you have added regions for shipping before this can be enabled');
        }
        return back()->with('toast_success', 'Successfully updated');
    }
    public function Orders($id)
    {
        $set = Settings::first();
        $xf = Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if ($set->store == 1) {
            if ($xf->store == 1) {
                $data['product'] = $product = Product::find($id);
                $data['orders'] = Order::whereproduct_id($id)->latest()->get();
                $data['title'] = $product->name;
                return view('user.product.store.orders', $data);
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('Store is not available for your country');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Store is currently unavailable');
        }
    }
    public function submitcategory(Request $request)
    {
        if (Auth::guard('user')->user()->live == 0) {
            $mode = 0;
        } else {
            $mode = 1;
        }
        $sav['user_id'] = Auth::guard('user')->user()->id;
        $sav['name'] = $request->name;
        $sav['mode'] = $mode;
        Productcategory::create($sav);
        return redirect()->route('user.product')->with('toast_success', 'Category succesfully created');
    }
    public function Editproduct($id)
    {
        if (Auth::guard('user')->user()->live == 0) {
            $mode = 0;
        } else {
            $mode = 1;
        }
        $data['product'] = $product = Product::whereref_id($id)->first();
        $data['store'] = Storefront::whereUser_id(Auth::guard('user')->user()->id)->wheremode($mode)->first();
        $data['images'] = Productimage::whereproduct_id($product->id)->get();
        $data['category'] = Fundcategory::wherestatus(1)->orderby('name', 'asc')->get();
        $data['title'] = $product->name;
        $data['shipping'] = Shipping::whereuser_id(Auth::guard('user')->user()->id)->wheremode($mode)->latest()->get();
        return view('user.product.store.edit_product', $data);
    }
    //End of product
}
