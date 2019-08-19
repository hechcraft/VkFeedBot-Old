<?php

namespace App\Posts;

class Audio extends VKPost
{

    public function getMessage()
    {
       return $message = 'Извините, но ВК жлобы';
    }
}
