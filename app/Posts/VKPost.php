<?php

namespace App\Posts;

class VKPost
{
    protected $response;
    protected $item;
    protected $postCount;

    public function __construct($response, $item, $postCount)
    {
        $this->response = $response;
        $this->item = $item;
        $this->postCount = $postCount;
    }

    public function getText($text)
    {
        //ид из поста
        $idPost = data_get($this->item, 'source_id');
        $idPost = $idPost * -1;
        //ид групп
        $groupArray = data_get($this->response, 'response.groups');
        $usersIdArray = data_get($this->response, 'response.profiles');
        //Передаем название паблика в пост
        for ($i = 0; $i < count($groupArray); $i++) {
            $idGroup = data_get($this->response, 'response.groups.' . $i . '.id');
            if ($idPost == $idGroup) {
                $name = data_get($this->response, 'response.groups.' . $i . '.name');
                $text = $name . ":\n" . $text;
                break;
            }
        }
        // Передаем имя пользователя в пост
        for ($i = 0; $i < count($usersIdArray); $i++) {
            $idUser = data_get($this->response, 'response.profiles.' . $i . '.id');
            $idUser = $idUser * -1;
            if ($idPost == $idUser) {
                $first_name = data_get($this->response, 'response.profiles.' . $i . '.first_name');
                $last_name = data_get($this->response, 'response.profiles.' . $i . '.last_name');
                $text = $first_name . ' ' . $last_name . ":\n" . $text;
            }
        }


        return $text;
    }

    public function getKey($request)
    {
        $photoKeys = array_keys((array)$request);
        $photos = [];
        for ($i = 0; $i < count($photoKeys); $i++) {
            $photos[$i] = strstr($photoKeys[$i], 'photo');
            if ($photos[$i] == false) {
                unset($photos[$i]);
            }
        }
        return end($photos);
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

    private function getBasePath($postCount)
    {
        return "response.items.$postCount.";
    }

    protected function getPath($path, $postCount)
    {
        $firstPath = $this->getBasePath($postCount) . 'copy_history.' . $postCount . '.' . $path;

        if ($data = data_get($this->response, $firstPath)) {
            return $data;
        }
        return data_get($this->response, $this->getBasePath($postCount) . $path);
    }

    protected function getAttachments($path)
    {
        $attachments = data_get($this->item, 'attachments');

        if (!$attachments) {
            $attachments = data_get($this->item, 'copy_history.0.attachments');
        }

        return collect($attachments)->map(function ($image) use ($path) {
            $image = data_get($image, $path);

            return [
                'url' => data_get($image, $this->getImageSize($image)),
                'caption' => data_get($image, $path . '.text')
            ];
        })->toArray();
    }


    protected function getPathText($postCount)
    {
        return $this->getPath('text', $postCount);
    }

    protected function getVideoId($postCount)
    {
        return $this->getPath('attachments.0.video.id', $postCount);
    }

    protected function getOwnerVideo($postCount)
    {
        return $this->getPath('attachments.0.video.owner_id', $postCount);
    }

    protected function getPostType($postCount)
    {
        return $this->getPath('attachments.0.type', $postCount);
    }

    protected function getDocUrl($postCount)
    {
        return $this->getPath('attachments.0.doc.url', $postCount);
    }

    protected function getDocTitle($postCount)
    {
        return $this->getPath('attachments.0.doc.title', $postCount);
    }

    protected function getGeoCoordinates($postCount)
    {
        return $this->getPath('geo.coordinates', $postCount);
    }

    protected function getIdUrFriend($postCount)
    {
        return $this->getPath('source_id', $postCount);
    }

    protected function getIdAddFriend($postCount)
    {
        return $this->getPath('friends.items.0.user_id', $postCount);
    }

}
