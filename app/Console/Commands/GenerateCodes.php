<?php

namespace App\Console\Commands;

use App\Models\Discount;
use App\Notifications\GeneratedCodes;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Notification;

class GenerateCodes extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:generate {count} {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate additional discount codes
                                {count : Amount of codes to be generated}
                                {--email : Comma separated list of recipients to receive a .tsv of generated codes}';

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
        $count = $this->argument('count') ?? 1;

        $last = Discount::count() ? Discount::latest()->first()->id : 0;

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        for ($i=0; $i<$count; $i++)
        {
            Discount::generate();
            $bar->advance();
        }

        $bar->finish();
        $this->info(''); // newline

        if ($this->option('email')) {
            $this->mail($last, $count);
        }

        $this->info('Done.');
    }

    protected function mail(int $offset = 0, int $count)
    {        
        $recipients = explode(',', $this->option('email'));

        if (empty($recipients)) {
            $this->error('No recipients provided.');
            return;
        }

        $discounts = Discount::query()
            ->where('id', '>', $offset)
            ->limit($count)
            ->get()
            ->pluck('code')
            ->toArray();

        $path = tempnam("/tmp", "bal");

        $handle = fopen($path, "w");
        fwrite($handle, implode("\t", $discounts));
        fclose($handle);
        
        foreach ($recipients as $recipient) {
            $this->info("Sending to: {$recipient}");
            Notification::route('mail', $recipient)
                ->notify(new GeneratedCodes($count, $path));
        }
        
        unlink($path);
    }
}
