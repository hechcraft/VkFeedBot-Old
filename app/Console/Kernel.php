<?php

namespace App\Console;

use App\Console\Commands\CleanUpDataBase;
use App\Console\Commands\FetchPosts;
use App\Console\Commands\SendPosts;
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
        CleanUpDataBase::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
            ->hourly();

        $schedule->command('posts:fetch')->everyMinute();
        $schedule->command('posts:send')->everyMinute();

        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->command('posts:cleanup')->monthlyOn(1, '15:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
