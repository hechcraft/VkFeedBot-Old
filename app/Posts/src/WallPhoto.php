<?php

namespace App\Posts\src;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class WallPhoto implements PostType
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
        $data = data_get($this->response, 'response.items.0.photos.items.0.photo_604');
        $attachment = new Image($data);
        $text = $this->text . ' добавил изображения...';
        return $message = OutgoingMessage::create($text)
            ->withAttachment($attachment);

    }
}