<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemindReturnBookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:return-book';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind users to return books before 3 days from the end date.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        RemindReturnBookJob::dispatch();
    }
}
