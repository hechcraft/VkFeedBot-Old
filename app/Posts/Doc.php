<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Doc extends VKPost
{
    public function getMessage()
    {
        $text = data_get($this->response, 'response.items.0.text');
        $data = data_get($this->response, 'response.items.0.attachments.0.doc.url');
        $attachment = new File($data);
        return OutgoingMessage::create($this->getText($text))
            ->withAttachment($attachment);
    }
}