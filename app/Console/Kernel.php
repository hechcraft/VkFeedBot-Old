<?php

namespace App\Console;

<<<<<<< HEAD
<<<<<<< HEAD
use App\Jobs\BotPost;
=======
use App\Jobs\HelloJob;
>>>>>>> 8b01fdf... Царский подгон
=======
use App\Jobs\BotPost;
>>>>>>> 4cbee79... 4
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
<<<<<<< HEAD
        $schedule->job(new BotPost)->everyMinute();
=======
         $schedule->job(new HelloJob)->everyMinute();
>>>>>>> 8b01fdf... Царский подгон
=======
        $schedule->job(new BotPost)->everyMinute();

>>>>>>> 4cbee79... 4
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
