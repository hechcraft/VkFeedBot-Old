<?php

namespace App\Posts;

class Audio implements PostType
{

    public function getMessage()
    {
       return $message = 'Извините, но ВК жлобы';
    }
}
