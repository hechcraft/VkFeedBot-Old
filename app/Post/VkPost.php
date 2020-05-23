<?php


namespace App\Post;


use App\VkGroupName;
use App\VkUserName;
use Illuminate\Support\Facades\DB;

class VkPost
{
    protected $decodeItem;
    protected $telegramId;

    public function __construct($decodeItem, $telegramId)
    {
        $this->decodeItem = $decodeItem;
        $this->telegramId = $telegramId;
    }

    public function getOwnerPost($idPost, $text)
    {
        if ($idPost < 0) {
            $idPost *= -1;
        }

        $groupsData = VkGroupName::pluck('vk_group_name', 'vk_id_group');
        $profilesData = VkUserName::pluck('vk_name_user', 'vk_id_user');

        if ($name = data_get($groupsData, $idPost)) {
            $text = $name . ":\n" . $text;
        } else if ($name = data_get($profilesData, $idPost)) {
            $text = $name . ":\n" . $text;
        }

        return $text;
    }


    protected function getPath($path)
    {
        $readyPath = data_get($this->decodeItem, 'copy_history.0.' . $path);
        if (isset($readyPath)) {
            return $readyPath;
        }
        return data_get($this->decodeItem, $path);

    }

    protected function getText()
    {
        return $this->getPath('text');
    }

    protected function getUrlPost()
    {
        $url = 'https://vk.com/feed?w=wall' . $this->getPath('source_id') . '_' . $this->getPath('post_id');
        return $url;
    }

    protected function getAttachments($path)
    {
        $attachments = data_get($this->decodeItem, 'attachments');
        if (!$attachments) {
            $attachments = data_get($this->decodeItem, 'copy_history.0.attachments');
        }

        return collect($attachments)->map(function ($image) use ($path) {
            $image = data_get($image, $path);

            return [
                'url' => data_get($image, $this->getImageSize($image)),
                'caption' => data_get($image, $path . '.text')
            ];
        })->toArray();
    }

    public function getImageSize($image)
    {
        $photoKeys = array_keys((array)$image);

        $photos = [];
        for ($i = 0; $i < count($photoKeys); $i++) {
            $photos[$i] = strstr($photoKeys[$i], 'photo');
            if ($photos[$i] == false) {
                unset($photos[$i]);
            }
        }
        return end($photos);
    }

    protected function getOwnerVideo()
    {
        return $this->getPath('attachments.0.video.owner_id');
    }

    protected function getVideoId()
    {
        return $this->getPath('attachments.0.video.id');
    }

    protected function getGeoCoordinates()
    {
        return $this->getPath('geo.coordinates');
    }

    protected function getDocTitle($amountDoc)
    {
        return $this->getPath("attachments.$amountDoc.doc.title");
    }

    protected function getDocUrl($amountDoc)
    {
        return $this->getPath("attachments.$amountDoc.doc.url");
    }

    protected function getIdUrFriend()
    {
        return $this->getPath('source_id');
    }

    protected function getIdAddFriend()
    {
        return $this->getPath('friends.items.0.user_id');
    }

    protected function getPostType()
    {
        return $this->getPath('attachments.0.type');
    }

    protected function getLink()
    {
        return $this->getPath('attachments.0.link.url');
    }
}
