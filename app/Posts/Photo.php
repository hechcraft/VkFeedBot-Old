<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Photo extends VKPost
{
    public function getMessage()
    {
        $text = data_get($this->response, 'response.items.0.text');
        $requestPhoto = data_get($this->response, 'response.items.0.attachments.0.photo');
        $data = data_get($this->response, 'response.items.0.attachments.0.photo.'
            . $this->getKey($requestPhoto));
        $attachment = new Image($data);
        return OutgoingMessage::create($this->getText($text))
            ->withAttachment($attachment);
    }
}
