<?php

namespace App\Http\Controllers;

use App\Services\Message;
use App\VkFeed;
use App\VkGroupName;
use App\VkOauth;
use App\VkUserName;
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

    public function store($bot, $stringUrl)
    {
        $data = new VkOauth;
        $data->telegram_id = $bot->getUser()->getId();
        parse_str($stringUrl, $parseUrl);
        $vkData = VkOauth::select('vk_id', 'telegram_id')
            ->where('telegram_id', $bot->getUser()->getId())->first();
        if (!isset($parseUrl['user_id'])) {
            $parseUrl['user_id'] = null;
        }

        if ($parseUrl['user_id'] === '' && $parseUrl['https://oauth_vk_com/blank_html#access_token']) {
            $bot->reply('Проверьте правильность введенего Url');
            return;
        }

        if ($vkData && ($vkData == $parseUrl['user_id'] || $vkData->telegram_id == $bot->getUser()->getId())) {
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
    }

    public function delete($bot)
    {
        VkOauth::where('telegram_id', $bot->getUser()->getId())->delete();
        VkFeed::where('telegram_id', $bot->getUser()->getId())->delete();
        VkGroupName::where('telegram_id', $bot->getUser()->getId())->delete();
        VkUserName::where('telegram_id', $bot->getUser()->getId())->delete();
        $bot->reply('Ваши данные успешно удалены');
    }
}
