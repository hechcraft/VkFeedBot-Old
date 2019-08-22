<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Point extends VKPost
{
    public function getMessage()
    {
        $text = data_get($this->response, 'response.items.0.text');
        $coord = data_get($this->response, 'response.items.0.geo.coordinates');
        $coordArr = explode(' ', $coord);
        $attachment = new Location($coordArr[0], $coordArr[1]);
        return OutgoingMessage::create($this->getText($text))
            ->withAttachment($attachment);
    }
}