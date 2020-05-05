<?php

namespace App\Posts;

use App\Services\Message;
class Photo extends VKPost
{
    public function getMessage()
    {
        $message = new Message();

        $message->withCaption($this->getText($this->getPathText($this->postCount)))
            ->withImage($this->getAttachments('photo'));
        return $message->getOutgoingMessage();
    }
}
