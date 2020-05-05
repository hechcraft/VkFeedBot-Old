<?php

namespace App\Posts;

use App\Services\Message;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Link extends VKPost
{
    public function getMessage()
    {
        $message = new Message();

        $message->withText($this->getText($this->getPathText($this->postCount)));

        return $message->getOutgoingMessage();
    }
}

