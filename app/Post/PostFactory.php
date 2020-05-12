<?php


namespace App\Post;

use Illuminate\Support\Facades\DB;

class PostFactory
{
    public static function make($bot)
    {
//        $telegramId = $bot->getUser()->getId();
        $telegramId = 1;
        $feedData = DB::table('vk_feed')->select('post_json')
            ->where('telegram_id', $telegramId)->get();
        $messages = collect([]);

        foreach ($feedData as $jsonItem) {
            $decodeItem = json_decode($jsonItem->post_json, true);
            $geoType = data_get($decodeItem, 'geo.type');
            if (!is_null($geoType)) {
                $type = $geoType;
            } elseif (!isset($decodeItem['attachments'])) {
                $type = $decodeItem['type'];
            } else {
                $type = data_get($decodeItem, 'attachments.0.type');
            }
            switch ($type) {
                case 'photo':
                    $messages->push(new Photo($decodeItem, $telegramId));
                    break;
                case 'video':
                    $messages->push(new Video($decodeItem, $telegramId));
                    break;
                case 'audio':
                    $messages->push(new Audio($decodeItem, $telegramId));
                    break;
                case 'point':
                    $messages->push(new Point($decodeItem, $telegramId));
                    break;
                case 'doc':
                    $messages->push(new Doc($decodeItem, $telegramId));
                    break;
                case 'link':
                    $messages->push(new Link($decodeItem, $telegramId));
                    break;
                case 'wall_photo':
                    break;
                case 'friend':
                    $messages->push(new Friend($decodeItem, $telegramId));
                    break;
                case 'post':
                    $messages->push(new Post($decodeItem, $telegramId));
                    break;
                default:
                    \Log::debug('Unsupported type: ' . $type);
                    \Log::debug(print_r($decodeItem, true));
                    break;
            }
        }
//        DB::table('vk_feed')->where('telegram_id',$telegramId)->delete();
        return $messages;
    }
}