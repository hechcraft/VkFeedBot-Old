<?php

namespace App\Posts;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Photo extends VKPost
{
	protected $response;

    private function getKey()
    {
        $requestPhoto = data_get($this->response, 'response.items.0.attachments.0.photo');
        $keysArrPhoto = array_keys((array)$requestPhoto);
        $photoArr = [];
        for ($i = 0; $i < count($keysArrPhoto); $i++) {
            $photoArr[$i] = strstr($keysArrPhoto[$i], 'photo');
            if ($photoArr[$i] == false) {
                unset($photoArr[$i]);
            }
        }
        return end($photoArr);
    }

	public function getMessage()
	{
	    $data = data_get($this->response, 'response.items.0.attachments.0.photo.' . $this->getKey());
	    $attachment = new Image($data);
	    return OutgoingMessage::create($this->getText())
	        ->withAttachment($attachment);	
	}
}