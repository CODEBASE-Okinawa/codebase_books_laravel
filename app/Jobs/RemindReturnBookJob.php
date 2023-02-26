<?php

namespace App\Jobs;

use App\Mail\RemindReturnBookMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Lending;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RemindReturnBookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('メールいくよっ！！');
        $threeDaysAfter  = Carbon::now()->addDays(3);
        $expiredLendings = Lending::with('user')->where('end_at', '<', $threeDaysAfter)->get();

        foreach ($expiredLendings as $expiredLending) {
            Mail::to($expiredLending->user->email)->send(new RemindReturnBookMail($expiredLending));
            Log::debug('メールおわった！！');
        }
    }
}
