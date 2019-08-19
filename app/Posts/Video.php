<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Video extends VKPost
{
    private function getKey()
    {
        $requestVideo = data_get($this->response, 'response.items.0.attachments.0.video');
        $keysArrVideo = array_keys((array)$requestVideo);
        $videoArr = [];
        for ($i = 0; $i < count($keysArrVideo); $i++) {
            $videoArr[$i] = strstr($keysArrVideo[$i], 'photo');
            if ($videoArr[$i] == false) {
                unset($videoArr[$i]);
            }
        }
        return end($videoArr);
    }

    public function getMessage()
    {
        $data = data_get($this->response, 'response.items.0.attachments.0.video.' . $this->getKey());
        $idVideo = data_get($this->response, 'response.items.0.attachments.0.video.id');
        $ownerIdVideo = data_get($this->response, 'response.items.0.attachments.0.video.owner_id');
        $videoUrl = 'https://vk.com/video' . $ownerIdVideo . '_' . $idVideo;
        $text = $this->getText() . "\n" . $videoUrl;
        $attachment = new Image($data);
        return OutgoingMessage::create($text)
            ->withAttachment($attachment);
    }
}