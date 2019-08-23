<?php

use App\Posts\PostFactory;
use BotMan\Drivers\Telegram\TelegramDriver;

$botman = resolve('botman');

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




https://oauth.vk.com/authorize?client_id=7108999&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=offline&response_type=token&v=5.52