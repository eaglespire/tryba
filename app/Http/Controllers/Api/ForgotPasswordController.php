<?php

namespace App\Http\Controllers\User;

use App\GeneralSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Settings;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    public function __construct()
    {
        $basic= Settings::first();

    }

    public function showLinkRequestForm()
    {
        $data['title'] = "Forgot password";
        return view('auth.passwords.email',$data);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $check = User::whereEmail($request->email)->count();
        if ($check == 0)
        {
            return back()->with('alert', 'There is no user with that e-mail address.');
        }else{
            $user = User::whereEmail($request->email)->first();
            $to =$user->email;
            $name = $user->name;
            $subject = 'Password Reset';
            $code = str_random(30);
            $link = url('/user-password/').'/reset/'.$code;
            DB::table('password_resets')->insert(
                ['email' => $to, 'token' => $code,  'created_at' => date("Y-m-d h:i:s")]
            );
            $gg=[
                'email'=>$to,
                'name'=>$name,
                'subject'=>$subject,
                'message'=>"Use This Link to Reset Password: <br> <a href='" . $link . "'>" . $link . "</a>"
            ];
            Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
            return back()->with('success', 'Password Reset Link sent to your email');
        }
    }
}
