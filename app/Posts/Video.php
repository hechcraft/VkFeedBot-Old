<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Video extends VKPost
{
    public function getMessage()
    {
        $text = data_get($this->response, 'response.items.0.text');
        $requestVideo = data_get($this->response, 'response.items.0.attachments.0.video');
        $data = data_get($this->response, 'response.items.0.attachments.0.video.'
            . $this->getKey($requestVideo, 'video'));
        $idVideo = data_get($this->response, 'response.items.0.attachments.0.video.id');
        $ownerIdVideo = data_get($this->response, 'response.items.0.attachments.0.video.owner_id');
        $videoUrl = 'https://vk.com/video' . $ownerIdVideo . '_' . $idVideo;
        $text = $this->getText($text) . "\n" . $videoUrl;
        $attachment = new Image($data);
        return OutgoingMessage::create($text)
            ->withAttachment($attachment);
    }
}