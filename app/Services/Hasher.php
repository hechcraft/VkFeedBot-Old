<?php

namespace App\Services;

class Hasher
{
    public static function makeFromPost($post)
    {
        return md5($post->source_id . $post->post_id);
    }
}