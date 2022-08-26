<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\User;
use App\Models\Storefrontcustomer;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\Storefront;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Password;
use DB;
use App\Models\PasswordReset;
use App\Models\CustomerPasswordReset;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/login';

    public function showResetForm($token)
    {
        $data['title'] = "Change Password";
         $tk =PasswordReset::where('token',$token)->first();
         if(is_null($tk))
         {
            $notification =  array('message' => 'Token Not Found!!','alert-type' => 'warning');
            return redirect()->route('user.password.request')->with($notification);
         }else{
            $email = $tk->email;
            return view('auth.passwords.reset',$data)->with(
                ['token' => $token, 'email' => $email]
            );
         }
    }

    public function reset(Request $request)
    {
        $tk =PasswordReset::where('token', $request->token)->first();
        $user = User::whereEmail($tk->email)->first();
        if(!$user)
        {
            return back()->with('toast_warning', 'Email do not match!!');
        }else{
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->route('login');
            return back()->with('toast_success', 'Successfully Password Reset.');
        }
    }
    public function customershowResetForm($token, $store_url)
    {
        $data['title'] = "Change Password";
        $data['store']=$store=Storefront::wherestore_url($store_url)->first();
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
}
