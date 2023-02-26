<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Lending;
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
//        $threeDaysAfter = Carbon::now()->addDays(3);
//        $expiredLendings = Lending::where('end_at', '<', $threeDaysAfter)->get();
//
//        $users = array();
//        foreach ($expiredLendings as $lending) {
//            $user = $lending->user;
//            $users[$user->id]['user'] = $user;
//            $users[$user->id]['books'][] = $lending->book;
//        }
//
//        foreach ($users as $userData) {
//            Mail::to($userData['user'])->send(new RemindReturnBookMail($userData['user'], $userData['books']));
//        }
    }
}
