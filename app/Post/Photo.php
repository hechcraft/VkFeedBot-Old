<?php


namespace App\Post;

use App\Services\Message;

class Photo extends VkPost
{
    public function getMessage()
    {
        $message = new Message();
        $message->withCaption($this->getOwnerPost($this->decodeItem['source_id'], $this->getText()), $this->getUrlPost())
            ->withImage($this->getAttachments('photo'));
        return $message->getOutgoingMessage();
    }
}