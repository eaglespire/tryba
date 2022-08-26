<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookingServices;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Models\Settings;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BookingsController extends Controller
{
    public function __construct()
    {
        $this->settings = Settings::find(1);
    }
    public function index()
    {
        $xf = auth()->guard('user')->user()->getCountrySupported();
        if ($this->settings->store == 1) {
            if ($xf->store == 1) {
                if (Auth::guard('user')->user()->kyc_verif_status == "APPROVED") {
                    if (Auth::guard('user')->user()->live == 1) {
                        $data['title'] = 'Website';
                        return view('user.product.appointment', $data);
                    } else {
                        $data['title'] = 'Error Message';
                        return view('user.merchant.error', $data)->withErrors('You can\'t access website in test mode');
                    }
                } else {
                    Session::put('storefront_compliance', Auth::guard('user')->user()->id);
                    $data['title'] = 'Error Message';
                    return view('user.merchant.error', $data)->withErrors('Compliance is currently due, please update your account information to avoid restrictions such as no access to website service.');
                }
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('Website is not available for your country');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Website is currently unavailable');
        }
    }
    public function add(){
        return view('user.product.services.create',['title' => 'Bookings']);   
    }
    public function create(Request $request){

        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'duration' => 'required|integer',
            'durationType' => 'required|in:minute,hour,day,week,month,year',
            'price' => 'required|integer',
            'image' => 'required|file|image|mimes:jpeg,png,jpg'
        ]);
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $fileUrl = "";
        if ($request->hasFile('image')) {
            $fileUrl = Cloudinary::uploadFile($request->file('image')->getRealPath())->getSecurePath();
        }

        $user=User::find(auth()->guard('user')->user()->id);
        BookingServices::create([
            'user_id' => auth()->guard('user')->user()->id,
            'store_id' => $user->storefront()->id,
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'durationType' => $request->durationType,
            'price' =>$request->price,
            'image' => $fileUrl
        ]);
        return redirect()->route('user.services')->with('toast_success', 'Service Added!');
    }

    public function edit($id){
        $service = BookingServices::findOrFail($id);
        return view('user.product.services.update',['title' => 'Services','service' => $service]);
    }

    public function putService(Request $request,$id){

        $request->validate([
            'name' => 'required|string|max:255',
            'description' =>'required',
            'duration' => 'required|integer',
            'durationType' => 'required|in:minute,hour,day,week,month,year',
            'price' => 'required|integer',
            'status' => 'boolean',
            'image' => 'file|image|mimes:jpeg,png,jpg'
        ]);
        $data = BookingServices::whereid($id)->first();

        $fileUrl = "";
        if ($request->hasFile('image')) {
            $fileUrl = Cloudinary::uploadFile($request->file('image')->getRealPath())->getSecurePath();
        }

        $data->name = $request->name;
        $data->description = $request->description;
        $data->duration = $request->duration;
        $data->durationType = $request->durationType;
        $data->price = $request->price;
        $data->status = $request->status;
        $data->image = ($request->hasFile('image')) ?  $fileUrl : $data->image;
        $data->save();
        return redirect()->route('user.services')->with([
            'toast_success' => "Service Updated!"
        ]);
    }
    public function delete($id){
        $service = BookingServices::whereid($id)->first();
        $service->delete();
        return back()->with('toast_success', 'Deleted!');
    }
}
