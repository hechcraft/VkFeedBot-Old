<?php

namespace App\Services;

use BotMan\BotMan\Messages\Attachments\Attachment;

class ImageCollection extends Attachment
{
    /** @var array */
    protected $collection;

    /**
     * Video constructor.
     * @param array $collection
     * @param mixed $payload
     */
    public function __construct($collection, $payload = null)
    {
        parent::__construct($payload);
        $this->collection = $collection;
    }

    /**
     * Get the instance as a web accessible array.
     * This will be used within the WebDriver.
     *
     * @return array
     */
    public function toWebDriver()
    {
        return $this->toMediaArray();
    }

    public function toMediaArray()
    {
        return collect($this->collection)->map(function ($image) {
            return [
                'type' => 'photo',
                'media' => $image['url'],
                'caption' => "",
            ];
        })->toArray();
    }

    /**
     * @return array
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * @param array $collection
     */
    public function setCollection(array $collection): void
    {
        $this->collection = $collection;
    }
}
