<?php


namespace App\Post;


use App\Services\Message;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Post extends VkPost
{
    public function createTextMessage()
    {
        $text = substr($this->getOwnerPost($this->decodeItem['source_id'], ''), 0, -2);
        $text .= ' сделал репост записи ';
        $text .= $this->getOwnerPost(data_get($this->decodeItem, 'copy_history.0.owner_id'), '');
        $text .= data_get($this->decodeItem, 'text') . "\n\n" . $this->getText();
        return $text;
    }

    public function getMessage()
    {
        $message = new Message();

        if (!isset($this->decodeItem['copy_history'])) {
            $text = $this->getOwnerPost($this->decodeItem['source_id'], $this->getText());
        } else {
            $text = $this->createTextMessage();
        }
        $postType = $this->getPostType();
        if ($this->getPath('geo.type') === 'point') {
            $postType = 'point';
        }
        if (is_null($postType)) {
            $postType = 'post';
        }
        switch ($postType) {
            case 'photo':
                $message->withCaption($text, $this->getUrlPost())
                    ->withImage($this->getAttachments('photo'));
                break;
            case 'post':
                $message->withCaption($this->getOwnerPost($this->decodeItem['source_id'], $this->getText()), $this->getUrlPost());
                break;
            case 'video':
                $videoUrl = "https://vk.com/video{$this->getOwnerVideo()}_{$this->getVideoId()}";
                $text .= "\n" . $videoUrl;
                $message->withCaption($text, $this->getUrlPost())
                    ->withImage($this->getAttachments('video'));
                break;
            case 'audio':
                $message->addText('Извините но вк жлобы');
                break;
            case 'doc':
                $amountDoc = 0;
                $ownerDoc = $text;
                $message->addText($ownerDoc)
                    ->addText($this->getDocTitle($amountDoc) . ':')
                    ->addText($this->getDocUrl($amountDoc));
                while (!is_null($this->getPath("attachments.$amountDoc.doc.url"))) {
                    $amountDoc++;
                    $message->addText($this->getDocTitle($amountDoc) . ':')
                        ->addText($this->getDocUrl($amountDoc));
                };
                break;
            case 'link':
                $message->withCaption($this->getOwnerPost($this->decodeItem['source_id'], $this->getText()
                    . "\n" . $this->getLink()), $this->getUrlPost());
                break;
            case 'point':
                $botman = resolve('botman');
                $coordArr = explode(' ', $this->getGeoCoordinates());
                $botman->reply($text);
                return OutgoingMessage::create()->withAttachment(new Location($coordArr[0], $coordArr[1]));
                break;
            default:
                \Log::debug("Unsupported type in class Post : $postType");
                \Log::debug(print_r($this->decodeItem, true));
                break;
        }
        return $message->getOutgoingMessage();
    }
}