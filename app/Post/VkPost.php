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
        $groupsData = VkGroupName::select('vk_id_group', 'vk_group_name')
            ->where('telegram_id', $this->telegramId)->get();

        $profilesData = VkUserName::select('vk_id_user', 'vk_name_user')
            ->where('telegram_id', $this->telegramId)->get();

        foreach ($groupsData as $group) {
            if ($idPost == $group->vk_id_group) {
                $name = $group->vk_group_name;
                $text = $name . ":\n" . $text;
                break;
            }
        }

        foreach ($profilesData as $user) {
            if ($idPost == $user->vk_id_user) {
                $name = $user->vk_name_user;
                $text = $name . ":\n" . $text;
                break;
            }
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
