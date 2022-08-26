<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Settings;
use App\Models\User;
use App\Jobs\SendInvoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InvoiceDailyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:invoiceReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Invoice reminder via email to customer with recurring payment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $set = Settings::first();
        if ($set->invoice == 1 AND $set->email_notify == 1 ) {
            $allDueInvoices = Invoice::where("invoice_type","recurring")->where("due_date", now()->format('Y-m-d'))->with('customer')->get();
            foreach ($allDueInvoices as $key => $allDueInvoice) {
                //Get user
                dispatch_sync(new SendInvoice($allDueInvoice->ref_id));
                 
            //    $user = User::whereid($allDueInvoice->user_id)->first();
            //    if($user->email_limit > $user->used_email || $user->sms_limit > $user->used_sms){
            //     updateEmailLimit($user->id); 
            //     }else{
            //     }
            }
        }

    }
}
