<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Post extends VKPost
{
    public function getMessage()
    {
        $text = data_get($this->response, 'response.items.0.copy_history.0.text');
        $postType = data_get($this->response, 'response.items.0.copy_history.0.attachments.0.type');
        if (is_null($postType)) {
            return $this->getText($text);
        } elseif ($postType == 'video') {
            $requestVideo = data_get($this->response, 'response.items.0.copy_history.0.attachments.0.video');
            $data = data_get($this->response, 'response.items.0.copy_history.0.attachments.0.video.' .
                $this->getKey($requestVideo));
            $idVideo = data_get($this->response, 'response.items.0.copy_history.0.attachments.0.video.id');
            $ownerIdVideo = data_get($this->response, 'response.items.0.copy_history.0.attachments.0.video.owner_id');
            $videoUrl = 'https://vk.com/video' . $ownerIdVideo . '_' . $idVideo;
            $text = $this->getText($text) . "\n" . $videoUrl;
            $attachment = new Image($data);
            return OutgoingMessage::create($text)
                ->withAttachment($attachment);
        } elseif ($postType == 'photo') {
            $requestPhoto = data_get($this->response, 'response.items.0.copy_history.0.attachments.0.photo');
            $data = data_get($this->response, 'response.items.0.copy_history.0.attachments.0.photo.' .
                $this->getKey($requestPhoto));
            $attachment = new Image($data);
            return OutgoingMessage::create($this->getText($text))
                ->withAttachment($attachment);
        }
    }
}
