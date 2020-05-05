<?php

namespace App\Posts;

use App\Services\Message;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Illuminate\Support\Facades\Log;

class Post extends VKPost
{
    public function getMessage()
    {
        $botman = resolve('botman');

        $text = $this->getText($this->getPathText($this->postCount));
        $postType = $this->getPostType($this->postCount);
        if (is_null($postType) || is_null($this->getPath('geo.type', $this->postCount))) {
            $postType = 'post';
        } else {
            $postType = 'geo';
        }
        $message = new Message;
        $messages = collect([]);
        switch ($postType) {
            case 'video':
                $videoUrl = "https://vk.com/video{$this->getOwnerVideo($this->postCount)}_{$this->getVideoId($this->postCount)}";
                $text .= "\n" . $videoUrl;

                $message->withCaption($text)
                    ->withImage($this->getAttachments('video'));
                break;
            case 'photo':
                $messages->push(new Photo($this->response, $this->item, $this->postCount));
//                $message
//                    ->withCaption($text)
//                    ->withImage($this->getAttachments('photo'));
                break;
            case 'doc':
                $message->addText($this->getPathText($this->postCount))
                    ->addText($this->getDocTitle($this->postCount))
                    ->addText('')
                    ->addText($this->getDocUrl($this->postCount));
                break;
            case 'geo':
                $coordArr = explode(' ', $this->getGeoCoordinates($this->postCount));
                $botman->reply($this->getText($this->getPathText($this->postCount)));
                return OutgoingMessage::create()->withAttachment(new Location($coordArr[0], $coordArr[1]));
                break;
            case 'post':
                $message->withCaption($text);
                break;
            default:
                $message->withText($text);
                break;
        }

        return $message->getOutgoingMessage();
    }
}
