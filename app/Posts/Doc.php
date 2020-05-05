<?php

namespace App\Posts;

use App\Services\Message;

class Doc extends VKPost
{
    public function getMessage()
    {
        $message = new Message();
        $amountDoc = 1;

        $ownerDoc = "Добавил файл: " . $this->getText($this->getPathText($this->postCount));

        $message->addText($ownerDoc)
            ->addText($this->getDocTitle($this->postCount) . ':')
            ->addText($this->getDocUrl($this->postCount));

        while (!is_null($this->getPath("attachments.$amountDoc.doc.url", $this->postCount))) {
            $message->addText($this->getDocTitle($this->postCount) . ':')
                ->addText($this->getDocUrl($this->postCount));
            $amountDoc++;
        };

        return $message->getOutgoingMessage();
    }
}

