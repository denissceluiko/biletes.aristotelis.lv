<?php

namespace App\Console\Commands;

use App\Models\Invite;
use Illuminate\Console\Command;

class CreatePersonInvite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invite:person {name} {surname} {email} {level} {phone?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a personal invite';

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
            'name' => $this->argument('name').' '.$this->argument('surname'),
            'type' => 'person',
            'redeems' => 1,
        ]);
        $invite->encode($this->arguments());

        $this->info(route('invite.show', $invite));
        return 0;
    }
}
