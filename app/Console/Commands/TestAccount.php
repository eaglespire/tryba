<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\SmsService;

class TestAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        (new SmsService)->fire('+447916239224', 'New verification message');
        // $pass = '37yUjzKTPL';
        // $u = User::where('email', 'testaccount6@onsecurity.co.uk')->first();
        // $u->update(['password' => \Hash::make($pass)]);
        // \Log::info($pass);
        return 0;
    }
}
