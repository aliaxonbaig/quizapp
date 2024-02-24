<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\BirthDayWish;
use Illuminate\Console\Command;

class SendBirthDayWish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:birthdaywish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends members birthday wish';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //$users = User::whereMonth('dob', '=', date('m'))->whereDay('dob', '=', date('d'))->get();
        $users = User::all();
        foreach ($users as $user){
            $user->notify(new BirthDayWish($user));
        }
    }
}
