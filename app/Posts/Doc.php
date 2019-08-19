<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Doc implements PostType
{
    use HasText;

    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getMessage()
    {
        $data = data_get($this->response, 'response.items.0.attachments.0.doc.url');
        $attachment = new File($data);
        return $message = OutgoingMessage::create($this->getText())
            ->withAttachment($attachment);
    }
}