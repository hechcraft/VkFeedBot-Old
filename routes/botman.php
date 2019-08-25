<?php

use App\Posts\PostFactory;
use BotMan\Drivers\Telegram\TelegramDriver;

$botman = resolve('botman');

$botman->hears('/start', function ($bot) {
    $bot->reply(
        sprintf(
            '<a href="https://oauth.vk.com/authorize?client_id=%s&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=%s&response_type=token&v=5.52">Authorize</a>',
            '7111219',
            'offline,friends,wall'
        ),
        ['parse_mode' => 'HTML']
    );
});

$urlTok = config('services.vk.url') . config('services.vk.token');
$response = json_decode(file_get_contents($urlTok));
$factory = PostFactory::make($response);
$message = $factory->getMessage();


$botman->hears('/help', function ($bot) use ($message) {
    $bot->reply($message);
});

$botman->hears('1', function ($bot) use ($botman) {
    \App\Jobs\BotPost::dispatch();
});

