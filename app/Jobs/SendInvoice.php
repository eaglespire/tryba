<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\User;
use App\Models\Countrysupported;
use App\Models\Settings;
use App\Models\Logo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $ref;
    public function __construct($ref)
    {
        $this->ref = $ref;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $link = Invoice::whereref_id($this->ref)->first();
        $customer = Customer::whereid($link->customer_id)->first();
        $link->sent = 1;
        $link->save();
        $user = User::whereid($link->user_id)->first();
        $currency = Countrysupported::whereid($user->pay_support)->first();
        $set = Settings::first();
        $mlogo = Logo::first();
        $from = env('MAIL_USERNAME');
        $sender_email = $customer->email;
        $site = $set->site_name;
        $payment_link = $link->ref_id;
        $amount = $currency->coin->name . ' ' . number_format(array_sum(json_decode($link->total)), 2);
    
        $logo = url('/') . '/asset/' . $mlogo->image_link;
        $sender_subject = 'Payment for Invoice #' . $link->ref_id;
        $sender_text = 'Invoice for #' . $link->ref_id . ' will be due by ' . date("j, M Y", strtotime($link->due_date));
    
        $data = array(
            'created' => $link->created_at,
            'sender_subject' => $sender_subject,
            'sender_name' => $site,
            'receiver_name' => $customer->first_name. ' ' .$customer->last_name,
            'website' => $set->site_name,
            'sender_text' => $sender_text,
            'payment_link' => $payment_link,
            'amount' => $amount,
            'logo' => $logo
        );
        Mail::send(['html' => 'emails/invoice/sender/invoice'], $data, function ($sender_text) use ($sender_email, $sender_subject, $from, $site) {
            $sender_text->to($sender_email)->subject($sender_subject)->from($from, $site);
        });
    }
}
