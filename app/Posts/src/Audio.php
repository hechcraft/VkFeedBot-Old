<?php

namespace App\Posts\src;

class Audio implements PostType
{
    private $response;
    private $text;

    public function __construct($response, $text)
    {
        $response->response = $response;
        $text->text = $text;
    }

    public function getMessage()
    {
       return $message = 'Извините, но ВК жлобы';
    }
}
