<?php

$botman = resolve('botman');
//
//$urlTok = config('services.vk.url') . config('services.vk.token');
//$response = json_decode(file_get_contents($urlTok));
//$factory = PostFactory::make($response);
//$message = $factory->getMessage();

<<<<<<< HEAD
<<<<<<< HEAD
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
=======
$botman->hears('/start', 'App\Http\Controllers\VkController@start');
>>>>>>> efa6e3c... New feature and bug fix

$botman->hears('/delete', '\App\Http\Controllers\VkController@delete');

<<<<<<< HEAD
<<<<<<< HEAD
=======
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
<<<<<<< HEAD
});




https://oauth.vk.com/authorize?client_id=7108999&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=offline&response_type=token&v=5.52
>>>>>>> 8b01fdf... Царский подгон
=======
});
>>>>>>> f8df5fe... Царский подгон
=======
$botman->hears('Url {stringUrl}', 'App\Http\Controllers\VkController@store');
>>>>>>> efa6e3c... New feature and bug fix
=======
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
>>>>>>> 078375d... WIP
