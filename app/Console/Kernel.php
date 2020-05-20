<?php

namespace App\Console;

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
use App\Console\Commands\CleanUpDataBase;
use App\Console\Commands\ClearDataBase;
>>>>>>> f1450d6... WIP
use App\Console\Commands\FetchPosts;
use App\Console\Commands\SendPosts;
>>>>>>> 7325e42... WIP
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
        FetchPosts::class,
        SendPosts::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
<<<<<<< HEAD
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
=======
        $schedule->command('posts:fetch')->everyMinute();
<<<<<<< HEAD
        $schedule->command('posts:send')->everyMinute();
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 7325e42... WIP
=======
        $schedule->command('posts:cleanup')->dailyAt('1:00');
>>>>>>> f1450d6... WIP
=======
>>>>>>> 6dc1906... WIP
=======
	$schedule->command('posts:send')->everyMinute();
	$schedule->command('horizon:snapshot')->everyFiveMinutes();
>>>>>>> 8baec8f... Add snapshots
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
