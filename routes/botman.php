<?php

use App\Posts\PostFactory;
Use App\VkPost;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Support\Facades\DB;

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

$botman->hears('/help', function ($bot) {

    $vkData = DB::table('vk_oauth')->select('telegram_id', 'last_post_id', 'vk_token')
        ->where('telegram_id', $bot->getUser()->getId())->first();

    if (is_null($vkData)) {
        $bot->reply('Попробуйте зарегистрироваться');
        return;
    }

    $urlTok = config('services.vk.url') . $vkData->vk_token;
    $response = json_decode(file_get_contents($urlTok));


    foreach (data_get($response, 'response.items') as $item) {
        $globalType = data_get($item, 'attachments');
        $geoType = data_get($item, 'geo.type');
        if (!is_null($geoType)) {
            $type = $geoType;
        } elseif (is_null($globalType)) {
            $type = data_get($item, 'type');
        } else {
            $type = data_get($item, 'attachments.0.type');
        }

//        \Log::info(print_r($item, true));
        $postJson = json_encode($item);
        app('App\Http\Controllers\FeedController')->store($bot, $postJson);
    }

    $md5Date = data_get($response, 'response.items.0.date');
    $md5Text = data_get($response, 'response.items.0.text');
    $md5tring = md5($md5Date . $md5Text);

//    if ($md5tring == $vkData->last_post_id)
//    {
//        exit();
//    }

    $messages = PostFactory::make($response);

    $messages->each(function ($message) use ($vkData, $bot) {
        $message = $message->getMessage();
        if ($vkData->telegram_id == $bot->getUser()->getId()) {
            $bot->reply($message);
        } else {
            $bot->reply('Попробуйте зарегистрироваться');
            return;
        }
    });

    DB::table('vk_oauth')->where('telegram_id', $bot->getUser()->getId())
        ->update(['last_post_id' => $md5tring]);

});

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
