<?php

namespace App\Console\Commands;

use App\Models\Discount;
use Illuminate\Console\Command;

class DiscountReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report on issued discounts';

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
        $headers = ['Sent', 'Generated'];
        $discounts = [
            [Discount::getSent(), Discount::getGenerated()]
        ];

        $this->table($headers, $discounts);
    }
}
