<?php

namespace App\Console\Commands;

use App\Mail\SendEmail;
use App\Models\BankingDetail;
use App\Services\ModulrService;
use App\Models\SubscriptionPlan;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DebitSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:debitUsers';
    protected $service;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove subscription fee from user after their subscription plan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ModulrService $service)
    {
        parent::__construct();
        $this->service = $service;
        $this->accountNumber = env("TRYBA_BANK_ACCOUNT");
        $this->address = env("TRYBA_BANK_ACCOUNT_ADDRESS");
        $this->postCode = env("TRYBA_BANK_ACCOUNT_POSTCODE");
        $this->postTown = env("TRYBA_BANK_ACCOUNT_POSTTOWN");
        $this->sortCode = env("TRYBA_BANK_ACCOUNT_SORTCODE");
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Get all user with expiring date
        $currentDate = now()->format('Y-m-d');
        $users = User::where('plan_expiring','<=', $currentDate)->get(); 
        foreach ($users as $key => $user) {
            //Calculate income

            $monthlyIncome = Transactions::whereReceiverId($user->id)->whereMode($user->live)->whereStatus(1)->where('type', '!=', 9)->whereMonth('created_at', Carbon::now()->month)->sum('amount');
            //Selecting plan
            $plan = SubscriptionPlan::where('annualstartPrice','<=',$monthlyIncome)->where('annualendPrice','>=',$monthlyIncome)->first();
            if(BankingDetail::where('user_id',$user->id)->exists()){
                $userBankDetails = BankingDetail::where('user_id',$user->id)->first();
                if($userBankDetails->balance >= $plan->amount){
                    //Create Payment with Modulr
                    $data = [
                        'amount' => $plan->amount,
                        'sourceAccountId' => $userBankDetails->accountId,
                        'payeeAccountNumber' => $this->accountNumber,
                        'payeeSortCode' => $this->sortCode,
                        'beneficiaryId' => '',
                        'payeeName' => 'Tryba.io',
                        'address' => $this->address,
                        'country' => 'GB',
                        'postCode' => $this->postCode,
                        'postTown' => $this->postTown,
                    ];
                    $payment = $this->service->createPayment(json_encode($data));

                    if(!$payment) {
                        // TryAgain
                    }else{
                        $newBalance = $userBankDetails->balance - $plan->amount;
                        $userBankDetails->balance = $newBalance;
                        $userBankDetails->save();
                        // Create a transaction
                        Transactions::create([
                            'ref_id' => randomNumber(11),
                            'type' => 9,
                            'amount' => $plan->amount,
                            'email' => 'support@tryba.io',
                            'first_name' => 'Tryba',
                            'last_name' => 'io',
                            'ip_address' => user_ip(),
                            'receiver_id' => $user->id,
                            'payment_link' => $plan->amount,
                            'currency' => $plan->currency_id,
                            'payment_type' => 'bank',
                            'status' => 1
                        ]);
    
                        // new expiring date
                        $user = User::whereid($user->id)->first();
                        $user->plan_id = $plan->id;
                        $user->plan_startDate = $currentDate = now()->format('Y-m-d');
                        $user->sms_limit = $plan->sms_limit;
                        $user->email_limit = $plan->email_limit;
                        $user->planOwingStatus == 0;
                        $user->plan_expiring = Carbon::now()->add($plan->duration.$plan->durationType);
                        $user->save();
                    }                    
                }else{
                    Log::info($user);
                    $user = User::whereid($user->id)->first();
                    if($user->planOwingStatus == 0){
                        $user->planChargesOwing = $user->planChargesOwing + $plan->amount;
                        $user->planOwingStatus = 1;
                        $user->save();
                        $data = [
                            'email'=>$user->email,
                            'name'=>$user->first_name.' '.$user->last_name,
                            'subject'=>'Failed subscription payment',
                            'message'=>'Dear '. $user->first_name .', <br> We could not deduct subscription fee of '. view_currency2($plan->currency_id).$plan->amount.'/'.$plan->durationType.' from your bank account. <br><br> Kindly fund your bank account so as to continue enjoying our services'
                        ];
                        Mail::to($data['email'], $data['name'])->send(new SendEmail($data['subject'], $data['message']));
                    }
                }
            }else{
                Log::info('dont have bank');
            }
           
        }
    }
}
