<?php

namespace App\Http\Controllers;

use App\VkPost;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VkController extends Controller
{
    //ссылка на регистрацию
    public function start($bot)
    {
        $bot->reply(
            sprintf(
                '<a href="https://oauth.vk.com/authorize?client_id=%s&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=%s&response_type=token&v=5.52">Authorize</a>',
                '7111219',
                'offline,friends,wall'
            ),
            ['parse_mode' => 'HTML']
        );
    }

    //сохранение в бд
    public function store($bot, $stringUrl)
    {
        $data = new VkPost;
        $data->telegram_id = $bot->getUser()->getId();
        parse_str($stringUrl, $parseUrl);
        $vkData = DB::table('vk_oauth')->select('vk_id', 'telegram_id')
            ->where('telegram_id', $bot->getUser()->getId())->first();
        if (!isset($parseUrl['user_id'])) {
            $parseUrl['user_id'] = null;
        }

        if ($parseUrl['user_id'] === '' && $parseUrl['https://oauth_vk_com/blank_html#access_token']) {
            $bot->reply('Проверьте правильность введенего Url');
            return;
        }

        if ($vkData->vk_id == $parseUrl['user_id'] || $vkData->telegram_id == $bot->getUser()->getId()) {
            $bot->reply('Вы уже зарегистрированы');
            return;
        }
        $data->vk_token = $parseUrl['https://oauth_vk_com/blank_html#access_token'];
        $data->vk_id = $parseUrl['user_id'];
        $data->save();

        $name = 'https://api.vk.com/method/users.get?&user_ids=' . $parseUrl['user_id'] .
            '&v=5.52&access_token=' . $parseUrl['https://oauth_vk_com/blank_html#access_token'];
        $response = json_decode(file_get_contents($name));
        $firstName = data_get($response, 'response.0.first_name');
        $lastName = data_get($response, 'response.0.last_name');
        $message = 'Добрый день ' . $firstName . ' '
            . $lastName . ', вы успешно авторизованы';

        resolve('botman')->reply($message);
        //        resolve('botman')->say('Authorized user ' . $bot->getUser()->getId(), TelegramDriver::class);
    }

    public function delete($bot)
    {
        DB::table('vk_oauth')->where('telegram_id', $bot->getUser()->getId())->delete();
    }
//    public function store(Request $request)
//    {
//        $value = \request()->session()->get('telegramId');
//        \Log::error($value);
//        if (!str_contains(request()->fullUrl(), 'redirected')) {
//            return view('redirect');
//        }
//        $code = request()->get('access_token');
//        $expiresIn = request()->get('expires_in');
//        $userId = request()->get('user_id');
//        var_dump($code, $expiresIn, $userId);
//        resolve('botman')->say('Authorized user ' . $userId, 121010156, TelegramDriver::class);
//        $data = new VkPost;
//        $data->VkId = $userId;
//        $data->VkToken = $code;
//        $data->save();
//    }
}
