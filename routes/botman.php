<?php

use App\Posts\PostFactory;
use BotMan\Drivers\Telegram\TelegramDriver;

$botman = resolve('botman');

$urlTok = config('services.vk.url') . config('services.vk.token');
$response = json_decode(file_get_contents($urlTok));
$factory = PostFactory::make($response);
$message = $factory->getMessage();

$botman->hears('/help', function ($bot) use ($message) {
    $bot->reply($message);
});

$botman->hears('/start', function ($bot) use ($botman, $message) {
    $botman->say($message, '1566560716001', TelegramDriver::class);
});






