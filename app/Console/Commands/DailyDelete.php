<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DailyDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete wizkids that have been fired since a week';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sevenDaysAgo = date('Y-m-d H:i:s', strtotime(date('y:m:d'). ' - 7 days'));
        $users = User::whereDate('fired_at','<=', $sevenDaysAgo)->where('working', '=', '0')->get();
        User::whereIn('id', $users->pluck('id'))->delete(); 
        $this->info('Successfully checked and deleted fired wizkids');
    }
}
