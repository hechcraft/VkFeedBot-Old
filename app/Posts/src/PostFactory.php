<?php

namespace App\Posts\src;

class PostFactory
{
    public static function make($response, $text): PostType
    {
        $globalType = data_get($response, 'response.items.0.attachments');

        if (is_null($globalType)) {
            $type = data_get($response, 'response.items.0.type');
        } else {
            $type = data_get($response, 'response.items.0.attachments.0.type');
        }
        switch ($type) {
            case 'video':
                return new Video($response, $text);
            case 'photo':
                return new Photo($response, $text);
            case 'audio':
                return new Audio($response, $text);
            case 'point':
                return new Point($response, $text);
            case 'doc':
                return new Doc($response, $text);
            case 'link':
                return new Link($response, $text);
            case 'wall_photo':
                return new WallPhoto($response, $text);
            case 'friend':
                return new Friend($response, $text);
            case 'post':
                return new Post($response,$text);
            default:
                throw new \RuntimeException('Invalid post type');
        }
    }
}