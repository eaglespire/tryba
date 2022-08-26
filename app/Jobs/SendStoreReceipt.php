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
use App\Models\Order;
use App\Models\Currency;
use App\Models\Transactions;
use App\Models\Countrysupported;
use App\Models\Logo;
use App\Models\Storefront;
use Swift_Mailer;
use Swift_SmtpTransport;
use Illuminate\Support\Facades\Mail;



class SendStoreReceipt implements ShouldQueue
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
        $this->ref = $ref;
        $this->type = $type;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $link = Order::whereref_id($this->ref)->first();
        $store = Storefront::whereid($link->store_id)->first();
        $set = Settings::first();
        if($store->mail==1){
            $transport = new Swift_SmtpTransport($store->mail_host, $store->mail_port, $store->mail_encryption);
            $transport->setUsername($store->mail_username);
            $transport->setPassword($store->mail_password);
            Mail::setSwiftMailer(new Swift_Mailer($transport));
            $from = $store->mail_from_address;
            $site = $store->mail_from_name;
        }else{
            updateEmailLimit($store->user_id);
            $from = env('MAIL_FROM_ADDRESS');
            $site = $set->site_name;
        }
        $receiver = User::whereid($link->user_id)->first();
        $from_currency = Currency::whereid($link->currency)->first();
        $payment_link = $link->ref_id;
        $dd = Transactions::whereref_id($this->token)->first();
        $currency = Countrysupported::whereid($receiver->pay_support)->first();

        $receiver_name = $receiver->first_name . ' ' . $receiver->last_name;
        $receiver_email = $receiver->email;
        if ($dd->sender_id != null) {
            $bb = User::whereid($dd->sender_id)->first();
            $sender_email = $bb->email;
        } else {
            $sender_email = $dd->email;
        }
        $details = $set->site_desc;
        $method = $this->type;
        $reference = $this->token;
        if ($dd->type == 2) {
            $from_amount = $from_currency->name . ' ' . number_format(($dd->amount + $dd->charge), 2);
            $to_amount = $currency->coin->name . ' ' . number_format($dd->amount, 2);
        } else {
            $from_amount = $from_currency->name . ' ' . number_format(($dd->amount + $dd->charge), 2);
            $to_amount = $currency->coin->name . ' ' . number_format($dd->amount - $dd->charge, 2);
        }
        $charge = $currency->coin->name . ' ' . number_format($dd->charge, 2);
        $receiver_subject = 'New successful transaction';
        $sender_subject = 'Payment was successful';
        $sender_text = 'Payment to ' . $receiver->first_name . ' ' . $receiver->last_name . ' was successful';
        $xx = User::whereid($dd->sender_id)->first();
        $sender_name = $xx->first_name . ' ' . $xx->last_name;
        $receiver_text = 'A payment from ' . $sender_name . ' was successfully received';

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
            'from_amount' => $from_amount,
            'to_amount' => $to_amount,
            'charges' => $charge,
            'method' => $method,
            'reference' => $reference,
            'payment_link' => $payment_link,
            'track_code' => $link->order_id,
        );

        Mail::send(['html' => 'emails/product/rpmail'], $data, function ($r_message) use ($receiver_name, $receiver_email, $receiver_subject, $from, $site) {
            $r_message->to($receiver_email, $receiver_name)->subject($receiver_subject)->from($from, $site);
        });
        Mail::send(['html' => 'emails/product/spmail'], $data, function ($s_message) use ($sender_name, $sender_email, $sender_subject, $from, $site) {
            $s_message->to($sender_email, $sender_name)->subject($sender_subject)->from($from, $site);
        });
    }
}
