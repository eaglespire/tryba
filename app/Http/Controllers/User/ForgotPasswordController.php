<?php

namespace App\Http\Controllers\User;

use App\GeneralSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Storefrontcustomer;
use App\Models\Settings;
use App\Models\Storefront;
use App\Models\Cart;
use App\Models\Product;
use DB;
use Session;
use App\Mail\SendEmail;
use App\Mail\ResetMail;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        $data['title'] = "Forgot password";
        return view('auth.passwords.email',$data);
    }
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $check = User::whereEmail($request->email)->count();
        if ($check==0){
            return back()->with('toast_success', 'If an account was found to '.$request->email.', you will receive a password reset link.');
        }else{
            $user = User::whereEmail($request->email)->first();
            $to =$user->email;
            $name = $user->name;
            $subject = 'Password Reset';
            $code = str_random(30);
            $link = url('/user-password/reset').'/'.$code;
            DB::table('password_resets')->insert(
                ['email' => $to, 'token' => $code,  'created_at' => date("Y-m-d h:i:s")]
            );
            // $gg=[
            //     'email'=>$to,
            //     'name'=>$name,
            //     'subject'=>$subject,
            //     'message'=>"Use This Link to Reset Password: <br> <a href='" . $link . "'>" . $link . "</a>"
            // ];
            \Mail::to($user->email)->send(new ResetMail($user, $link));
            // Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
            return back()->with('toast_success', 'If an account was found to '.$request->email.', you will receive a password reset link.');
        }
    }
    public function customershowLinkRequestForm($store_url)
    {
        $data['title'] = "Forgot password";
        $data['store']=$store=Storefront::wherestore_url($store_url)->first();
        $data['merchant']=$merchant=User::whereid($store->user_id)->first();
        return view('user.product.theme.' . $store->theme_id . '.account.customer-email', $data);
    }

    public function customersendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $store=Storefront::wherestore_id($request->store_id)->first();
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
            \Mail::to($user->email)->send(new ResetMail($user, $link));
            // Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
            return back()->with('toast_success', 'If an account was found to '.$request->email.', you will receive a password reset link.');
        }
    }
}
