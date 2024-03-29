<?php

namespace App\Console\Commands;

use App\Models\Invite;
use Illuminate\Console\Command;

class CreateGroupInvite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invite:group {redeems : How many times a code can be redeemed} {level : free, regular, vip, svip, org} {name*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a group invite';

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
            'type' => 'group',
            'redeems' => $this->argument('redeems'),
        ]);

        $invite->encode([
            'level' => $this->argument('level'),
        ]);

        $this->info(route('invite.show', $invite));
        return 0;
    }
}
