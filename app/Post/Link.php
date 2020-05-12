<?php


namespace App\Post;


use App\Services\Message;

class Link extends VkPost
{
    public function getMessage()
    {
        $message = new Message();

        $message->withCaption($this->getOwnerPost($this->decodeItem['source_id'], $this->getText() . "\n" . $this->getLink()), $this->getUrlPost());

        return $message->getOutgoingMessage();
    }
}