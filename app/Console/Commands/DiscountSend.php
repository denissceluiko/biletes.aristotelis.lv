<?php

namespace App\Console\Commands;

use App\Discount;
use Illuminate\Console\Command;

class DiscountSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:send {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Force send an issued discount ignoring the timeout. Appends @students.lu.lv or @lu.lv if omitted.';

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
        $email = $this->argument('email');

        if (strpos($email, '@') === false) {
            $email .= '@'.(strlen($email) == 7 ? 'students.lu.lv' : 'lu.lv');
        }

        Discount::findByEmail($email)->mail($email);
        $this->info('Discount sent to: '.$email);
    }
}
