<?php

namespace App\Services;

class Hasher
{
    public static function makeFromPost($date, $text)
    {
        return md5($date . $text);
    }
}