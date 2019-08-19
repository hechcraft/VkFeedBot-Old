<?php

namespace App\Posts;

class Post extends VKPost
{
    public function getMessage()
    {
        return $this->getText();
    }
}
