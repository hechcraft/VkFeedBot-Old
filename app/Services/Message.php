<?php

namespace App\Services;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Message
{
    /**
     * @var OutgoingMessage
     */
    private $outgoingMessage;

    public function __construct()
    {
        $this->outgoingMessage = CustomOutgoingMessage::create();
    }

    /**
     * @return OutgoingMessage
     */
    public function getOutgoingMessage(): OutgoingMessage
    {
        return $this->outgoingMessage;
    }

    /**
     * @param string $caption
     * @return $this
     */
    public function withCaption($caption, $url)
    {
        if (strlen($caption) > 1000) {
            $caption = str_limit($caption, 850);
            $caption .= "\n" . $url;
        }
        $this->outgoingMessage->text($caption);
        return $this;
    }
    /**
     * @param array $images
     * @return $this
     */
    public function withImage(array $images)
    {
        if (count($images) < 2) {
            $this->outgoingMessage->withAttachment(new Image(data_get($images, '0.url')));
            return $this;
        }

        $this->outgoingMessage->withAttachment(new ImageCollection($images));

        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function withText($text)
    {
        $this->outgoingMessage->text($text);

        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function addText($text)
    {
        $existingText = $this->outgoingMessage->getText();

        $this->outgoingMessage->text($existingText . "\n" . $text);

        return $this;
    }
}