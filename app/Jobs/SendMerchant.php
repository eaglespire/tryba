<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Settings;
use App\Models\User;
use App\Models\Currency;
use App\Models\Transactions;
use App\Models\Countrysupported;
use App\Models\Logo;
use App\Models\Merchant;
use App\Models\Exttransfer;
use Illuminate\Support\Facades\Mail;

class SendMerchant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $ref; 
    public $type; 
    public $token;
    public function __construct($ref, $type, $token)
    {
        $this->ref=$ref;
        $this->type=$type;
        $this->token=$token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $link = Merchant::wheremerchant_key($this->ref)->first();
        $dd = Exttransfer::wherereference($this->token)->first();
        $xx = Transactions::whereref_id($this->token)->first();
        $receiver = User::whereid($link->user_id)->first();
        $currency = Countrysupported::whereid($receiver->pay_support)->first();
        $from_currency = Currency::whereid($dd->currency)->first();
        $set = Settings::first();
        $mlogo = Logo::first();
    
        $receiver_name = $receiver->first_name . ' ' . $receiver->last_name;
        $from = env('MAIL_USERNAME');
        if ($link->email != null) {
            $receiver_email = $link->email;
        } else {
            $receiver_email = $receiver->email;
        }
        if ($dd->sender_id != null) {
            $bb = User::whereid($dd->user_id)->first();
            $sender_email = $bb->email;
        } else {
            $sender_email = $dd->email;
        }
        $site = $set->site_name;
        $details = $set->site_desc;
        $method = $this->type;
        $reference = $this->token;
        $payment_link = $link->ref_id;
        $from_amount = $from_currency->name . ' ' . number_format($dd->total, 2);
        $to_amount = $currency->coin->name . ' ' . number_format($dd->total * $currency->rate / $dd->rate, 2);
        $charge = $currency->coin->name . ' ' . number_format($dd->charge * $currency->rate / $dd->rate, 2);
        $logo = url('/') . '/asset/' . $mlogo->image_link;
        $receiver_subject = 'New successful transaction';
        $sender_subject = 'Payment was successful';
        $sender_text = 'Payment to ' . $receiver->first_name . ' ' . $receiver->last_name . ' was successful';
    
        if ($dd->sender_id == null) {
            $sender_name = $dd->first_name . ' ' . $dd->last_name;
            $receiver_text = 'A payment from ' . $dd->first_name . ' ' . $dd->last_name . ' was successfully received';
        } else {
            $xx = User::whereid($dd->user_id)->first();
            $sender_name = $xx->first_name . ' ' . $xx->last_name;
            $receiver_text = 'A payment from ' . $sender_name . ' was successfully received';
        }
    
        $data = array(
            'created' => $dd->created_at,
            'sender_subject' => $sender_subject,
            'receiver_subject' => $receiver_subject,
            'receiver_name' => $receiver_name,
            'sender_name' => $sender_name,
            'website' => $set->site_name,
            'sender_text' => $sender_text,
            'receiver_text' => $receiver_text,
            'details' => $details,
            'to_amount' => $to_amount,
            'from_amount' => $from_amount,
            'charges' => $charge,
            'method' => $method,
            'reference' => $reference,
            'payment_link' => $payment_link,
            'logo' => $logo
        );
        Mail::send(['html' => 'emails/merchant/receiver/rpmail'], $data, function ($r_message) use ($receiver_name, $receiver_email, $receiver_subject, $from, $site) {
            $r_message->to($receiver_email, $receiver_name)->subject($receiver_subject)->from($from, $site);
        });
        Mail::send(['html' => 'emails/merchant/sender/spmail'], $data, function ($s_message) use ($sender_name, $sender_email, $sender_subject, $from, $site) {
            $s_message->to($sender_email, $sender_name)->subject($sender_subject)->from($from, $site);
        });
    }
}
