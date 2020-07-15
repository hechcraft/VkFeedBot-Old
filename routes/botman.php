<?php

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
$botman->hears('/start', 'App\Http\Controllers\VkController@start');

$botman->hears('/delete', '\App\Http\Controllers\VkController@delete');

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

$botman->hears('Url {stringUrl}', 'App\Http\Controllers\VkController@store');

$botman->hears('/url {stringUrl}', 'App\Http\Controllers\VkController@store');

$botman->hears('/help', function ($bot) {
    $bot->reply("Для прохождения регистрации необходимо выполнить следующие действия: 
    1) Написать боту /start;
    2) Перейти по полученной ссылке;
    3) Скопировать URL из адресной строки вашего браузера;
    4) Написать команду /URL и через пробел вставить скопированный URL
    
    Для удаление вваших данных из бота воспользуйтесь командой /delete.
    
    P.S. Важно. По поводу предупреждения VK чтобы не передавать код, действительно узнав код можно получить много данных с аккаунта. Но в данном случае разрешение выдается только на те вещи, которые нужны для просмотра Вашей стены и не более.
");
});
