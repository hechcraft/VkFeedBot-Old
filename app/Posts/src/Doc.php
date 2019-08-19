<?php

namespace App\Posts\src;

use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Doc implements PostType
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
        $data = data_get($this->response, 'response.items.0.attachments.0.doc.url');
        $attachment = new File($data);
        return $message = OutgoingMessage::create($this->text)
            ->withAttachment($attachment);
    }
}