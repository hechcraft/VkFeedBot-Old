<?php

namespace App\Posts\src;

class Post implements PostType
{
    private $response;
    private $text;

    public function __construct($response, $text)
    {
        $response->response = $response;
        $text->text = $response;
    }

    public function getMessage()
    {
        return $message = $this->text;
    }
}
