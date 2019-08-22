<?php

use App\Posts\PostFactory;

$botman = resolve('botman');

$urlTok = config('services.vk.url') . config('services.vk.token');
$response = json_decode(file_get_contents($urlTok));
$factory = PostFactory::make($response);
$message = $factory->getMessage();



$botman->hears('/help', function ($bot) use ($message) {
    $bot->reply($message);
});

$botman->hears('1', function ($bot) {
    $bot->reply('2');
});




