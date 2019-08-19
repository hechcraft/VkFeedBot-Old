<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class WallPhoto extends VKPost
{
    protected $response;

    public function __construct($response)
    {
        $this->response = $response;
    }


    public function getMessage()
    {
        $data = data_get($this->response, 'response.items.0.photos.items.0.photo_604');
        $attachment = new Image($data);
        $text = $this->getText() . ' добавил изображения...';
        return $message = OutgoingMessage::create($text())
            ->withAttachment($attachment);

    }
}