<?php

namespace App\Services;

class Hasher
{
    public static function makeFromPost($post)
    {
        $postId = $post->post_id ?? $post->text;
        if (!$postId){
            $postId = serialize($post);
        }
        return md5($post->source_id . $postId);
    }
}