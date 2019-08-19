<?php

namespace App\Posts;

class Post implements PostType
{
    use HasText;

    public function getMessage()
    {
        return $message = $this->getText();
    }
}
