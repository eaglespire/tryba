<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Stripe\StripeClient;
use App\Models\User;
use App\Models\Settings;
use App\Models\Currency;
use App\Models\Gateway;
use App\Models\Exttransfer;
use App\Models\Merchant;
use App\Models\Audit;
use App\Models\Transactions;
use App\Models\Charges;
use App\Models\History;
use App\Models\Country;
use App\Models\Sub;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Models\Countrysupported;
use Str;
use Image;
use File;
use Propaganistas\LaravelPhone\PhoneNumber;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use DB;
use App\Mail\SendEmail;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Mail;

class CastroController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $check = User::whereEmail($request->email)->count();
        if ($check == 0) {
            return response()->json(['message' => 'If an account was found to ' . $request->email . ', you will receive a password reset link.', 'status' => 'success', 'data' => null], 201);
        } else {
            $user = User::whereEmail($request->email)->first();
            $to = $user->email;
            $name = $user->name;
            $subject = 'Password Reset';
            $code = str_random(30);
            $link = url('/user-password/') . '/reset/' . $code;
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
            return response()->json(['message' => 'If an account was found to ' . $request->email . ', you will receive a password reset link.', 'status' => 'success', 'data' => null], 201);
        }
    }
    public function package()
    {
        $xf = Countrysupported::whereid(Auth::user()->pay_support)->first();
        $data['plan'] = Sub::wherecountry_id($xf->id)->get();
        return response()->json(['message' => 'success', 'data' => $data], 201);
    }
    public function verify_payment($tx_ref)
    {
        $ref = Exttransfer::wheretx_ref($tx_ref)->count();
        if ($ref == 0) {
            return response()->json(['message' => 'Invalid transaction', 'status' => 'failed', 'data' => null], 404);
        } else {
            $ext = Exttransfer::wheretx_ref($tx_ref)->first();
            $merchant = Merchant::wheremerchant_key($ext->merchant_key)->first();
            $user = User::whereId($merchant->user_id)->first();
            $verify = Exttransfer::wheretx_ref($tx_ref)->first();
            $email = $verify->email;
            $first_name = $verify->first_name;
            $last_name = $verify->last_name;
            if ($verify->status == 0) {
                $message = "Transaction is Pending";
                $status = "Pending";
            } elseif ($verify->status == 1) {
                $message = "Transaction is Complete";
                $status = "Paid";
            } elseif ($verify->status == 2) {
                $message = "Transaction was Cancelled";
                $status = "Cancelled";
            } elseif ($verify->status == 3) {
                $message = "Transaction was Abandoned";
                $status = "Abandoned";
            } elseif ($verify->status == 4) {
                $message = "Paymnt was Refunded";
                $status = "Refunded";
            }
            return response()->json([
                'message' => $message,
                'status' => $status,
                'data' => [
                    'id' => $verify->id,
                    'email' => $email,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'payment_type' => $verify->payment_type,
                    'title' => $verify->title,
                    'description' => $verify->description,
                    'quantity' => $verify->quantity,
                    'reference' => $verify->reference,
                    'amount' => number_format($verify->amount, 2),
                    'merchant_key' => $verify->merchant_key,
                    'callback_url' => rtrim($verify->callback_url, '/\\'),
                    'return_url' => rtrim($verify->return_url, '/\\'),
                    'tx_ref' => $verify->tx_ref,
                    'created_at' => $verify->created_at,
                    'updated_at' => $verify->updated_at,
                ],
            ], 200);
        }
    }
    public function compliance(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $set = Settings::find(1);
        $validator = Validator::make($request->all(), [
            'idcard' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 'failed'], 201);
        }
        if ($request->hasFile('idcard')) {
            $image = $request->file('idcard');
            $filename = 'id_file' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            if ($user->id_file != null) {
                $path = public_path('asset/profile/');
                $link = $path . $user->id_file;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->save($location);
            $user->id_type = $request->id_type;
            $user->id_file = $filename;
            $user->save();
        }
        if ($request->hasFile('address')) {
            $image = $request->file('address');
            $filename = 'address_file' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            if ($user->id_file != null) {
                $path = public_path('asset/profile/');
                $link = $path . $user->address_file;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->save($location);
            $user->address_file = $filename;
            $user->save();
        }
        $user->due = 1;
        $user->business_name = $request->business_name;
        $user->website_link = $request->website_link;
        $user->product_description = $request->product_description;
        $user->state = $request->state;
        $user->line_1 = $request->line_1;
        $user->line_2 = $request->line_2;
        $user->city = $request->city;
        $user->b_day = $request->b_day;
        $user->b_month = $request->b_month;
        $user->b_year = $request->b_year;
        $user->postal_code = $request->postal_code;
        $user->gender = $request->gender;
        $user->save();
        if ($set->email_notify == 1) {
            $gg=[
                'email'=>$set->email,
                'name'=>$set->site_name,
                'subject'=>'New Compliance',
                'message'=>"Compliance review request from " . $user->first_name . ' ' . $user->last_name
            ];
            Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
            $gg=[
                'email'=>$user->email,
                'name'=>$user->first_name . ' ' . $user->last_name,
                'subject'=>'Compliance',
                'message'=>"Compliance request is under review"
            ];
            Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
        }
        return response()->json(['message' => 'Currently verifying your documents', 'status' => 'success'], 201);
    }
    public function payment(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $xf=Countrysupported::whereid(Auth::user()->pay_support)->first();
        if ($request->bank_transfer == 1) {
            if($xf->bank_format=="uk"){
                if ($request->acct_no == null || $request->routing_number == null) {
                    return response()->json(['message' => 'Provide all Bank Credentials', 'status' => 'failed'], 201);
                } else {
                    $validator = Validator::make($request->all(), [
                        'acct_no' => 'required|string',
                        'routing_number' => 'required|string',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['message' => $validator->errors(), 'status' => 'failed'], 201);
                    }
                    $user->acct_no = $request->acct_no;
                    $user->routing_number = $request->routing_number;
                    $user->payment = 1;
                }
            }elseif($xf->bank_format=="eur"){
                if ($request->acct_no == null) {
                    return response()->json(['message' => 'Provide all Bank Credentials', 'status' => 'failed'], 201);
                } else {
                    $validator = Validator::make($request->all(), [
                        'acct_no' => 'required|string',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['message' => $validator->errors(), 'status' => 'failed'], 201);
                    }
                    $user->acct_no = $request->acct_no;
                    $user->payment = 1;
                }
            }
        }
        if ($request->stripe == 1) {
            if ($request->stripe_public_key == null || $request->stripe_secret_key == null) {
                return response()->json(['message' => 'Provide all Stripe Credentials', 'status' => 'failed'], 201);
            } else {
                $validator = Validator::make($request->all(), [
                    'stripe_public_key' => 'required|string',
                    'stripe_secret_key' => 'required|string',
                ]);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors(), 'status' => 'failed'], 201);
                }
                $user->stripe_public_key = $request->stripe_public_key;
                $user->stripe_secret_key = $request->stripe_secret_key;
                $user->payment = 1;
            }
        }
        if ($request->paypal == 1) {
            if ($request->paypal_client_id == null || $request->paypal_secret_key == null) {
                return response()->json(['message' => 'Provide all Paypal Credentials', 'status' => 'failed'], 201);
            } else {
                $validator = Validator::make($request->all(), [
                    'paypal_client_id' => 'required|string',
                    'paypal_secret_key' => 'required|string',
                ]);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors(), 'status' => 'failed'], 201);
                }
                $user->paypal_client_id = $request->paypal_client_id;
                $user->paypal_secret_key = $request->paypal_secret_key;
                $user->payment = 1;
            }
        }
        if ($request->coinbase == 1) {
            if ($request->coinbase_api_key == null) {
                return response()->json(['message' => 'Provide all Coinbase Credentials', 'status' => 'failed'], 201);
            } else {
                $validator = Validator::make($request->all(), [
                    'coinbase_api_key' => 'required|string',
                ]);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors(), 'status' => 'failed'], 201);
                }
                $user->coinbase_api_key = $request->coinbase_api_key;
                $user->payment = 1;
            }
        }
        $user->stripe = $request->stripe;
        $user->bank_transfer = $request->bank_transfer;
        $user->paypal = $request->paypal;
        $user->coinbase = $request->coinbase;
        $user->save();
        $audit['user_id'] = Auth::user()->id;
        $audit['trx'] = str_random(16);
        $audit['log'] = 'Updated payment method';
        Audit::create($audit);
        return response()->json(['message' => 'Payment Method Updated Successfully', 'status' => 'success'], 201);
    }
    public function payment_methods($user_id)
    {
        $user = User::whereid(Auth::user()->id)->first();
        $xf = Countrysupported::whereid(Auth::user()->pay_support)->first();
        if ($user->bank_transfer == 1) {
            if ($xf->bank_format == "uk") {
                $data['bank_transfer'] = [
                    'acct_no' => $user->acct_no,
                    'routing_number' => $user->routing_number,
                ];
            } elseif ($xf->bank_format == "eur") {
                $data['bank_transfer'] = [
                    'acct_no' => $user->acct_no,
                ];
            }
        }
        if ($user->stripe == 1) {
            $data['stripe'] = [
                'stripe_public_key' => $user->stripe_public_key,
                'stripe_secret_key' => $user->stripe_secret_key
            ];
        }
        if ($user->paypal == 1) {
            $data['paypal'] = [
                'paypal_client_id' => $user->paypal_client_id,
                'paypal_secret_key' => $user->paypal_secret_key
            ];
        }
        if ($user->coinbase == 1) {
            $data['coinbase'] = [
                'coinbase_api_key' => $user->coinbase_api_key,
            ];
        }
        return response()->json(['message' => 'success', 'data' => $data], 201);
    }
    public function preferences(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->support_email = $request->support_email;
        $user->checkout_logo = $request->checkout_logo;
        if ($request->checkout_theme == "bg-white") {
            $user->checkout_theme = null;
        } else {
            $user->checkout_theme = $request->checkout_theme;
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            if ($user->image != 'person.png') {
                $path = public_path('asset/profile/');
                File::delete($path . $user->image);
            }
            Image::make($image)->resize(172, 172)->save($location);
            $user->image = $filename;
            $user->save();
        }
        $user->social_links = $request->social_links;
        $user->display_support_email = $request->display_support_email;
        $user->save();
        return response()->json(['message' => 'Profile Updated successfully'], 201);
    }
    public function account(Request $request)
    {
        $set = Settings::first();
        $user = User::findOrFail(Auth::user()->id);
        if ($user->phone != $request->phone) {
            $check = User::wherePhone($request->phone)->count();
            if ($check < 1) {
                if ($set->sms_verification == 1) {
                    try {
                        $user->phone_verify = 0;
                        $user->phone = PhoneNumber::make($request->phone, $user->xd->iso)->formatE164();
                        $user->save();
                        return response()->json(['message' => 'Profile Updated successfully'], 201);
                    } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
                        return response()->json(['message' => $e->getMessage()], 201);
                    }
                }
            } else {
                return response()->json(['message' => 'Mobile Number already in use.'], 201);
            }
        }
    }
    public function social(Request $request)
    {
        $data = User::findOrFail(Auth::user()->id);
        $data->fill($request->all())->save();
        $data->save();
        $info = [
            'facebook' => $data->facebook,
            'twitter' => $data->twitter,
            'instagram' => $data->instagram,
            'linkedin' => $data->linkedin,
            'youtube' => $data->youtube,
        ];
        return response()->json(['message' => 'success', 'data' => $info], 201);
    }
    public function password(Request $request)
    {
        $user = User::whereid(Auth::user()->id)->first();
        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json(['message' => 'Password Changed successfully'], 201);
        } elseif (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid Password'], 201);
        }
    }
    public function credential()
    {
        $user = User::findOrFail(Auth::user()->id);
        $user = array_add($user, 'checkout', asset('asset/profile/'.$user->image));
        return response()->json(['message' => 'success', 'data' => $user], 201);
    }
    public function logout()
    {
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
            $user->fa_expiring = Carbon::now()->subMinutes(30);
            $user->save();
            session()->forget('oldLink');
            session()->forget('uniqueid');
            Auth::logout();
            return response()->json(['message' => 'Logout Successful'], 201);
        } else {
            return response()->json(['message' => 'Logout Successful'], 201);
        }
    }
    public function emailCheck()
    {
        if (Auth::user()->email_verify == 0) {
            $user = User::find(Auth::user()->id);
            $set = Settings::first();
            if (Carbon::parse($user->email_time)->addMinutes(1) > Carbon::now()) {
                $time = Carbon::parse($user->email_time)->addMinutes(1);
                $delay = $time->diffInSeconds(Carbon::now());
                $delay = gmdate('i:s', $delay);
                return response()->json(['message' => 'You can resend verification code after ' . $delay . ' minutes'], 201);
            } else {
                $code = strtoupper(Str::random(32));
                $user->email_time = Carbon::now();
                $user->verification_code = $code;
                $user->save();
                $gg=[
                    'email'=>$user->email,
                    'name'=>$user->first_name . ' ' . $user->last_name,
                    'subject'=>'We need to verify your email address',
                    'message'=>'Thanks you for signing up to Tryba.<br> As part of our securtiy checks we need to verify your email address. Simply click on the link below and job done.<br><a href=' . route('user.confirm-email', ['id' => $code]) . '>' . route('user.confirm-email', ['id' => $code]) . '</a>'
                ];
                Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                return response()->json(['message' => 'Verification code was sent successfully'], 201);
            }
        } elseif (Auth::user()->email_verify == 1) {
            return response()->json(['message' => Auth::user()->email . ' has already been verified'], 201);
        }
    }
    public function smsVerify(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->sms_code == $request->sms_code) {
            $user->phone_verify = 1;
            $user->save();
            return response()->json(['message' => 'Your mobile no has been verified successfully'], 201);
        } else {
            return response()->json(['message' => 'Verification Code didn\'t match'], 201);
        }
        return back();
    }
    public function phoneCheck()
    {
        if (Auth::user()->phone_verify == 0) {
            $user = User::find(Auth::user()->id);
            $set = Settings::first();
            if (Carbon::parse($user->phone_time)->addMinutes(1) > Carbon::now()) {
                $time = Carbon::parse($user->email_time)->addMinutes(1);
                $delay = $time->diffInSeconds(Carbon::now());
                $delay = gmdate('i:s', $delay);
                return response()->json(['message' => 'You can resend verification code after ' . $delay . ' minutes'], 201);
            } else {
                $code = randomNumber(6);
                $user->phone_time = Carbon::now();
                $user->verification_code = $code;
                $user->save();
                dispatch(new SendSms($user->phone, 'Your Verification Code is ' . $code));
                return response()->json(['message' => 'Verification code was sent successfully'], 201);
            }
        } elseif (Auth::user()->email_verify == 1) {
            return response()->json(['message' => Auth::user()->email . ' has already been verified'], 201);
        }
    }
    public function client_currency()
    {
        $xf = Countrysupported::whereid(Auth::user()->pay_support)->first();
        $currency = Currency::whereid($xf->coin_id)->first();
        return response()->json(['message' => 'success', 'data' => $currency], 201);
    }
    public function client_country()
    {
        $country = Country::whereid(Auth::user()->country)->first();
        return response()->json(['message' => 'success', 'data' => $country], 201);
    }
    public function client_transactions()
    {
        $data['pending'] = number_format(Transactions::wherereceiver_id(Auth::user()->id)->wheremode(1)->wherestatus(0)->sum('amount'), 2);
        $data['success'] = number_format(Transactions::wherereceiver_id(Auth::user()->id)->wheremode(1)->wherestatus(1)->sum('amount'), 2);
        $data['failed'] = number_format(Transactions::wherereceiver_id(Auth::user()->id)->wheremode(1)->wherestatus(2)->sum('amount'), 2);
        return response()->json(['message' => 'success', 'data' => $data], 201);
    }
    public function transactions()
    {
        $data['transactions'] = Transactions::wherereceiver_id(Auth::user()->id)->get();
        return response()->json(['message' => 'success', 'data' => $data], 201);
    }
    public function filtertransactions($id)
    {
        if ($id == "date") {
            $data['transactions'] = Transactions::wherereceiver_id(Auth::user()->id)->orderby('updated_at', 'desc')->get();
        } elseif ($id == "amount") {
            $data['transactions'] = Transactions::wherereceiver_id(Auth::user()->id)->orderby('amount', 'asc')->get();
        }
        return response()->json(['message' => 'success', 'data' => $data], 201);
    }
    public function client_billing_plan($id)
    {
        $data['plan'] = Sub::whereid($id)->first();
        return response()->json(['message' => 'success', 'data' => $data], 201);
    }
    public function generate_token(Request $request)
    {
        $mode = User::wheresecret_key($request->secret_key)->count();
        if ($mode == 1) {
            $user = User::wheresecret_key($request->secret_key)->first();
            $token = $user->createToken('my-app-token')->plainTextToken;
            $response = [
                'token' => $token
            ];
            return response($response, 201);
        } else {
            $test = User::wheretest_secret_key($request->secret_key)->count();
            if ($test == 1) {
                $user = User::wheretest_secret_key($request->secret_key)->first();
                $token = $user->createToken('my-app-token')->plainTextToken;
                $response = [
                    'token' => $token
                ];
                return response($response, 201);
            } else {
                return response()->json(['message' => 'Invalid Secret key', 'status' => 'failed', 'data' => null], 400);
            }
        }
    }

    public function initiate_transaction(Request $request)
    {
        $check = Merchant::whereMerchant_key($request->merchant_key)->whereStatus(1)->count();
        if ($check > 0) {
            $token = randomNumber(11);
            $data['merchant'] = $merchant = Merchant::whereMerchant_key($request->merchant_key)->first();
            $user = User::whereid($merchant->user_id)->first();
            $diff = $user->plan_payments - $user->used_payments;
            if (($request->quantity * $request->amount) < $diff || ($request->quantity * $request->amount) == $diff) {
                if ($user->plan_transactions > $user->used_transactions) {
                    $validator = Validator::make($request->all(), [
                        'merchant_key' => ['required', 'max:16', 'string'],
                        'public_key' => ['required', 'max:50', 'string'],
                        'amount' => ['required', 'numeric', 'between:0,99999999999.99'],
                        'email' => ['required', 'max:255'],
                        'first_name' => ['required', 'max:100'],
                        'last_name' => ['required', 'max:100'],
                        'callback_url' => ['required', 'url'],
                        'return_url' => ['required', 'url'],
                        'tx_ref' => ['required', 'string'],
                        'title' => ['required', 'string'],
                        'description' => ['required', 'string'],
                        'quantity' => ['required', 'int', 'min:1'],
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['message' => $validator->errors(), 'status' => 'failed', 'data' => null], 400);
                    }
                    $validatorf = new EmailValidator();
                    $multipleValidations = new MultipleValidationWithAnd([
                        new RFCValidation(),
                        new DNSCheckValidation()
                    ]);
                    if ($validatorf->isValid($request->email, $multipleValidations)) {
                    } else {
                        return response()->json(['message' => 'Invalid email address', 'status' => 'failed', 'data' => null], 400);
                    }
                    if ($merchant->mode == 0) {
                        $mode = 0;
                        $pb = $user->test_public_key;
                    } else {
                        $mode = 1;
                        $pb = $user->public_key;
                    }
                    $xf = Countrysupported::whereid($user->pay_support)->first();
                    if ($xf->merchant == 1) {
                        if ($user->status == 0) {
                            $dfd = Exttransfer::wheretx_ref($request->tx_ref)->count();
                            if ($dfd == 0) {
                                $mer = new Exttransfer();
                                $mer->reference = $token;
                                $mer->receiver_id = $merchant->user_id;
                                $mer->amount = $request->amount;
                                $mer->quantity = $request->quantity;
                                $mer->total = $request->quantity * $request->amount;
                                $mer->title = $request->title;
                                $mer->description = $request->description;
                                $mer->merchant_key = $request->merchant_key;
                                $mer->callback_url = $request->callback_url;
                                $mer->return_url = $request->return_url;
                                $mer->tx_ref = $request->tx_ref;
                                $mer->email = $request->email;
                                $mer->first_name = $request->first_name;
                                $mer->last_name = $request->last_name;
                                $mer->ip_address = user_ip();
                                $mer->status = 0;
                                $mer->currency = $xf->coin_id;
                                $mer->mode = $mode;
                                $mer->save();
                                $response = [
                                    'reference' => $token,
                                    'checkout_url' => route('transfer.process', ['id' => $request->merchant_key, 'xx' => $token]),
                                ];
                                return response()->json(['message' => 'Transaction Initiated', 'status' => 'success', 'data' => $response], 201);
                            } else {
                                return response()->json(['message' => 'Transaction reference has been created before', 'status' => 'failed', 'data' => null], 400);
                            }
                        } else {
                            return response()->json(['message' => 'User can\'t receive payments', 'status' => 'failed', 'data' => null], 400);
                        }
                    } else {
                        return response()->json(['message' => 'API Checkout is not available for this Merchant', 'status' => 'failed', 'data' => null], 400);
                    }
                } else {
                    return response()->json(['message' => 'Merchant have exceeded the number of transactions he/she can perform this month', 'status' => 'failed', 'data' => null], 400);
                }
            } else {
                return response()->json(['message' => 'Amount Exceeds Merchant Subscription Payment Limit', 'status' => 'failed', 'data' => null], 400);
            }
        } else {
            return response()->json(['message' => 'Invalid merchant key', 'status' => 'failed', 'data' => null], 400);
        }
    }

    public function userPlan(){
        $user = User::find(Auth::user()->id);
        $plan = SubscriptionPlan::where('id',$user->plan_id)->first();
        $total = Transactions::whereReceiverId($user->id)->whereMode($user->live)->whereStatus(1)->where('type', '!=', 9)->whereBetween('created_at', 
        [$user->plan_startDate, $user->plan_expiring])->sum('amount');
        $currency =  getUserCurrencyName($user);
        return response()->json([
            'message' => 'success', 
            'plan' => $plan, 
            'totalTransofMonth' => $total,
            'emailUsed' =>  $user->used_email,
            'smsUsed' => $user->used_sms,
            'currency' => $currency
        ], 200);
    }
}
