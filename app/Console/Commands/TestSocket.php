<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Events\NewMessage;
use Illuminate\Console\Command;

class TestSocket extends Command
{
    protected $signature = 'test:socket';
    protected $description = 'Just a test socket';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $invoice = Invoice::first();

        event(new NewMessage($invoice));
    }
}
