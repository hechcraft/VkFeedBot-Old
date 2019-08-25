<?php

namespace App\Jobs;

use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class BotPost
{
    use Dispatchable,SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        resolve('botman')->say('Hello', '121010156', TelegramDriver::class);
    }
}
