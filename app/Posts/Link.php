<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Link extends VKPost
{
    private function getKey()
    {
        $requestPhoto = data_get($this->response, 'response.items.0.attachments.0.photo');
        $keysArrPhoto = array_keys((array)$requestPhoto);
        $photoArr = [];
        for ($i = 0; $i < count($keysArrPhoto); $i++) {
            $photoArr[$i] = strstr($keysArrPhoto[$i], 'photo');
            if ($photoArr[$i] == false) {
                unset($photoArr[$i]);
            }
        }
        return end($photoArr);
    }

    public function getMessage()
    {
        $data = data_get($this->response, 'response.items.0.attachments.0.link.photo.' . $this->getKey());
        $link = data_get($this->response, 'response.items.0.attachments.0.link.url');
        $text = $this->getText() . "\n" . $link;
        $attachment = new Image($data);
        return OutgoingMessage::create($text)
            ->withAttachment($attachment);
    }
}

