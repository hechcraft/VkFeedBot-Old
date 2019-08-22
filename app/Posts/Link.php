<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Link extends VKPost
{
    public function getMessage()
    {
        $text = data_get($this->response, 'response.items.0.text');
        $requestPhoto = data_get($this->response, 'response.items.0.attachments.0.photo');
        $data = data_get($this->response, 'response.items.0.attachments.0.link.photo.'
            . $this->getKey($requestPhoto, 'photo'));
        $link = data_get($this->response, 'response.items.0.attachments.0.link.url');
        $text = $this->getText($text) . "\n" . $link;
        $attachment = new Image($data);
        return OutgoingMessage::create($text)
            ->withAttachment($attachment);
    }
}

