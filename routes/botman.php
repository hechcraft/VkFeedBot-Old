<?php

use App\Posts\PostFactory;
use BotMan\Drivers\Telegram\TelegramDriver;

$botman = resolve('botman');
//
//$urlTok = config('services.vk.url') . config('services.vk.token');
//$response = json_decode(file_get_contents($urlTok));
//$factory = PostFactory::make($response);
//$message = $factory->getMessage();

$botman->hears('1', function ($bot) use ($botman) {
    \App\Jobs\HelloJob::dispatch();
});

$botman->hears('start', function ($bot) {
    $bot->reply(
        sprintf(
            '<a href="https://oauth.vk.com/authorize?client_id=%s&display=page&redirect_uri=http://botman.test/success&scope=%s&response_type=token&v=5.52">Authorize</a>',
            '7109046',
            'offline'
        ), ['parse_mode' => 'HTML']
    );
});