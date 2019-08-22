<?php

namespace App\Posts;

class PostFactory
{
    public static function make($response)
    {

        $globalType = data_get($response, 'response.items.0.attachments');
        if (is_null($globalType)) {
            $type = data_get($response, 'response.items.0.type');
        } else {
            $type = data_get($response, 'response.items.0.attachments.0.type');
        }
        switch ($type) {
            case 'video':
                return new Video($response);
            case 'photo':
                return new Photo($response);
            case 'audio':
                return new Audio($response);
            case 'point':
                return new Point($response);
            case 'doc':
                return new Doc($response);
            case 'link':
                return new Link($response);
            case 'wall_photo':
                return new WallPhoto($response);
            case 'friend':
                return new Friend($response);
            case 'post':
                return new Post($response);
            default:
                throw new \RuntimeException('Invalid post type');
        }
    }
}