<?php

namespace App\Console\Commands;

use App\Jobs\RemindReturnBookJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RemindReturnBookCommand extends Command
{
    /**
     * The name and signature of the console command.
     * php artisan remind:return-book
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
        Log::debug('start RemindReturnBookJob'); // 残しとく
        RemindReturnBookJob::dispatch();
    }
}
