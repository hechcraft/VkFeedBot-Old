<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class WallPhoto extends VKPost
{
    public function getMessage()
    {
        $text = data_get($this->response, 'response.items.0.text');
        $requestPhoto = data_get($this->response, 'response.items.0.photos.items.0');
        $data = data_get($this->response, 'response.items.0.photos.items.0.'
            . $this->getKey($requestPhoto));
        $attachment = new Image($data);
        $text = $this->getText($text) . ' добавил изображения...';
        return OutgoingMessage::create($text)
            ->withAttachment($attachment);
    }
}
