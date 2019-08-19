<?php

namespace App\Posts\src;

interface PostType
{
    public function __construct($response, $text);

    public function getMessage();
}