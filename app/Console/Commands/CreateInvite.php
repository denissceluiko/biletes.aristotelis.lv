<?php

namespace App\Console\Commands;

use App\Invite;
use Illuminate\Console\Command;

class CreateInvite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invite:create {redeems : How many times a code can be redeemed} {name*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an invite';

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

        $invite = Invite::create([
            'name' => implode(' ', $this->argument('name')),
            'redeems' => $this->argument('redeems'),
        ]);

        $this->info(route('invite.show', $invite));
        return 0;
    }
}
