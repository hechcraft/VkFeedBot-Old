<?php

namespace App\Posts\src;

use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Point implements PostType
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
        $coord = data_get($this->response, 'response.items.0.geo.coordinates');
        $coordArr = explode(' ', $coord);
        $attachment = new Location($coordArr[0], $coordArr[1]);
        return $message = OutgoingMessage::create($this->text)
            ->withAttachment($attachment);
    }
}