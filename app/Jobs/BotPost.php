<?php

namespace App\Jobs;

use App\Posts\PostFactory;
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
        //это для автоматической работы
        $urlTok = config('services.vk.url') . config('services.vk.token');
        $response = json_decode(file_get_contents($urlTok));
        $factory = PostFactory::make($response);
//        $message = $factory->getMessage();
        resolve('botman')->say($factory->getMessage(), '121010156', TelegramDriver::class);
    }
}
