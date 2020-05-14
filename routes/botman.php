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

$botman->hears('/delete',  '\App\Http\Controllers\VkController@delete');

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
