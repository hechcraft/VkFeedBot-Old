<?php


namespace App\Post;

class PostFactory
{
    public static function make($post, $telegramId)
    {
        $messages = collect([]);

        $geoType = data_get($post, 'geo.type');
        if (!is_null($geoType)) {
            $type = $geoType;
        } elseif (!isset($post['attachments'])) {
            $type = data_get($post, 'type');
        } else {
            $type = data_get($post, 'attachments.0.type');
        }
        switch ($type) {
            case 'photo':
                $messages->push(new Photo($post, $telegramId));
                break;
            case 'video':
                $messages->push(new Video($post, $telegramId));
                break;
            case 'audio':
                break;
            case 'point':
                $messages->push(new Point($post, $telegramId));
                break;
            case 'doc':
                $messages->push(new Doc($post, $telegramId));
                break;
            case 'link':
                $messages->push(new Link($post, $telegramId));
                break;
            case 'wall_photo':
                break;
            case 'friend':
                $messages->push(new Friend($post, $telegramId));
                break;
            case 'post':
                $messages->push(new Post($post, $telegramId));
                break;
            default:
                \Log::debug('Unsupported type: ' . $type);
                \Log::debug(print_r($post, true));
                break;
        }

        return $messages;
    }
}