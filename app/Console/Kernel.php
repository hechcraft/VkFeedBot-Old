<?php

namespace App\Console;

<<<<<<< HEAD
use App\Jobs\BotPost;
=======
use App\Jobs\HelloJob;
>>>>>>> 8b01fdf... Царский подгон
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                  ->hourly();

<<<<<<< HEAD
        $schedule->job(new BotPost)->everyMinute();
=======
         $schedule->job(new HelloJob)->everyMinute();
>>>>>>> 8b01fdf... Царский подгон
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
