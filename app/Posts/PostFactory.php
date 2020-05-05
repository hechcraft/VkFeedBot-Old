<?php

namespace App\Posts;

class PostFactory
{
    public static function make($response)
    {
        $messages = collect([]);
        $postCount = -1;
        foreach (data_get($response, 'response.items') as $item) {
            $globalType = data_get($item, 'attachments');
            $geoType = data_get($item, 'geo.type');
            if (!is_null($geoType)) {
                $type = $geoType;
                $postCount++;
            } elseif (is_null($globalType)) {
                $type = data_get($item, 'type');
                $postCount++;
            } else {
                $type = data_get($item, 'attachments.0.type');
                $postCount++;
            }
            switch ($type) {
                case 'video':
                    $messages->push(new Video($response, $item, $postCount));
                    break;
                case 'photo':
                    $messages->push(new Photo($response, $item, $postCount));
                    break;
                case 'audio':
                    $messages->push(new Audio($response, $item, $postCount));
                    break;
                case 'point':
                    $messages->push(new Point($response, $item, $postCount));
                    break;
                case 'doc':
                    $messages->push(new Doc($response, $item, $postCount));
                    break;
                case 'link':
                    $messages->push(new Link($response, $item, $postCount));
                    break;
                case 'wall_photo':
                    //$messages->push(new WallPhoto($response, $item, $postCount));
                    break;
                case 'friend':
                    $messages->push(new Friend($response, $item, $postCount));
                    break;
                case 'post':
                    $messages->push(new Post($response, $item, $postCount));
                    break;
                default:
                    \Log::debug('Unsupported type: ' . $type);
                    break;
            }

        }
        return $messages;
    }
}
