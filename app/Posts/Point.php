<?php

namespace App\Posts;

use App\Services\Message;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Point extends VKPost
{
    public function getMessage()
    {
        $botman = resolve('botman');

        $coordArr = explode(' ', $this->getGeoCoordinates($this->postCount));
        $botman->reply($this->getText($this->getPathText($this->postCount)));
        return OutgoingMessage::create()->withAttachment(new Location($coordArr[0], $coordArr[1]));
    }
}