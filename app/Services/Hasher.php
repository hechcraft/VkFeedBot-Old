<?php

namespace App\Services;

class Hasher
{
    public static function makeFromPost($post)
    {
        $postId = $post->post_id ?? $post->text;
        return md5($post->source_id . $postId);
    }
}