<?php


namespace App\Post;


use App\Services\Message;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Point extends VkPost
{
    public function getMessage()
    {
        $botman = resolve('botman');

        $coordArr = explode(' ', $this->getGeoCoordinates());
        $botman->reply($this->getOwnerPost($this->decodeItem['source_id'], $this->getText()));
        return OutgoingMessage::create()->withAttachment(new Location($coordArr[0], $coordArr[1]));
    }
}