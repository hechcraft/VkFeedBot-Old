<?php

use Mpociot\BotMan\Messages\Message;
use App\Posts\PostFactory;
use BotMan\BotMan\Messages\Attachments\Image;
$botman = resolve('botman');

$TOKENVK = 'c524e7184a62f272331cacfe6807795c6442b90de9be1d3719d238840502fcef5e1df66dae681324e9484';
$URL = 'https://api.vk.com/method/newsfeed.get?&filters=posts&count=5&return_banned=0&v=5.52&access_token=';
$urlTok = $URL . $TOKENVK;

$response = json_decode(file_get_contents($urlTok));
$text = data_get($response, 'response.items.0.text');

$factory = PostFactory::make($response,$text);
$message = $factory->getMessage();

$botman->hears('/help', function ($bot) use ($message) {
    $bot->reply($message);
});

$botman->hears('1', function ($bot) {
    $bot->reply('2');
});




