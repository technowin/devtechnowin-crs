<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CommonController;

class SendContractExpiryMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contracts:send-expiry-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for contracts nearing expiry';

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
     * @return mixed
     */
    
    public function handle()
{
    try {
        $common = new CommonController();
        $common->SendContractExpiryReminders();

        $this->info('Contract expiry reminder emails processed.');
    } catch (\Exception $e) {
        $this->error('Message: ' . $e->getMessage());
        $this->error('File: ' . $e->getFile());
        $this->error('Line: ' . $e->getLine());
    }
}

}