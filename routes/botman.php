<?php

use Mpociot\BotMan\Messages\Message;
use App\Posts\src\PostFactory;
use BotMan\BotMan\Messages\Attachments\Image;
$botman = resolve('botman');

$TOKENVK = 'c524e7184a62f272331cacfe6807795c6442b90de9be1d3719d238840502fcef5e1df66dae681324e9484';
$URL = 'https://api.vk.com/method/newsfeed.get?&filters=posts&count=5&return_banned=0&v=5.52&access_token=';
$urlTok = $URL . $TOKENVK;
$message = '';
$botman = resolve('botman');

$response = json_decode(file_get_contents($urlTok));
$text = data_get($response, 'response.items.0.text');
$name = '';

//ид из поста
$idPost = data_get($response, 'response.items.0.source_id');
$idPost = $idPost * -1;
//ид групп
$groupArray = data_get($response, 'response.groups');
$usersIdArray = data_get($response, 'response.profiles');
//Передаем название паблика в пост
for ($i = 0; $i < count($groupArray); $i++) {
    $idGroup = data_get($response, 'response.groups.' . $i . '.id');
    if ($idPost == $idGroup) {
        $name = data_get($response, 'response.groups.' . $i . '.name');
        $text = $name . "\n\n" . $text;
        break;
    }
}
// Передаем имя пользователя в пост
for ($i = 0; $i < count($groupArray); $i++) {
    $idUser = data_get($response, 'response.profiles.' . $i . '.id');
    $idUser = $idUser * -1;
    if ($idPost == $idUser) {
        $first_name = data_get($response, 'response.profiles.' . $i . '.first_name');
        $last_name = data_get($response, 'response.profiles.' . $i . '.last_name');
        $text = $first_name . ' ' . $last_name . "\n\n" . $text;
    }
}

$factory = PostFactory::make($response,$text);
$message = $factory->getMessage();

$botman->hears('/help', function ($bot) use ($message) {
    $bot->reply($message);
});

$botman->hears('1', function ($bot) {
    $bot->reply('2');
});




