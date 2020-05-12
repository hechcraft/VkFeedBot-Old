<?php


namespace App\Post;

use App\Services\Message;

class Doc extends VkPost
{
    public function getMessage()
    {
        $message = new Message();
        $amountDoc = 0;

        $ownerDoc = "Добавил файл: " . $this->getOwnerPost($this->decodeItem['source_id'], $this->getText());

        $message->addText($ownerDoc)
            ->addText($this->getDocTitle($amountDoc) . ':')
            ->addText($this->getDocUrl($amountDoc));

        while (!is_null($this->getPath("attachments.$amountDoc.doc.url"))) {
            $amountDoc++;
            $message->addText($this->getDocTitle($amountDoc) . ':')
                ->addText($this->getDocUrl($amountDoc));
        };

        return $message->getOutgoingMessage();
    }
}