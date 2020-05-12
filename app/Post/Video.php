<?php


namespace App\Post;


use App\Services\Message;

class Video extends VkPost
{
    public function getMessage()
    {
        $message = new Message();
        $videoUrl = "https://vk.com/video{$this->getOwnerVideo()}_{$this->getVideoId()}";
        $message->withCaption($this->getOwnerPost($this->decodeItem['source_id'], $this->getText()) . "\n" . $videoUrl, $this->getUrlPost())
            ->withImage($this->getAttachments('video'));
        return $message->getOutgoingMessage();
    }
}

