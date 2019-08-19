<?php

namespace App\Posts;

trait HasText
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getText()
    {
        $text = data_get($this->response, 'response.items.0.text');

        //ид из поста
        $idPost = data_get($this->response, 'response.items.0.source_id');
        $idPost = $idPost * -1;
        //ид групп
        $groupArray = data_get($this->response, 'response.groups');
        $usersIdArray = data_get($this->response, 'response.profiles');
        //Передаем название паблика в пост
        for ($i = 0; $i < count($groupArray); $i++) {
            $idGroup = data_get($this->response, 'response.groups.' . $i . '.id');
            if ($idPost == $idGroup) {
                $name = data_get($this->response, 'response.groups.' . $i . '.name');
                $text = $name . "\n\n" . $text;
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
                $text = $first_name . ' ' . $last_name . "\n\n" . $text;
            }
        }


        return $text;
    }
}
