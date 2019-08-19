<?php

namespace App\Posts;

class Post extends VKPost
{
    public function getMessage()
    {
        return $message = $this->getText();
    }
}
