<?php

namespace App\Posts;

use App\Services\Message;

class Video extends VKPost
{
    public function getMessage()
    {
        $message = new Message();

        $videoUrl = "https://vk.com/video{$this->getOwnerVideo($this->postCount)}_{$this->getVideoId($this->postCount)}";
        $message->withCaption($this->getPathText($this->postCount) . "\n" . $videoUrl)
            ->withImage($this->getAttachments('video'));

        return $message->getOutgoingMessage();
    }
}
