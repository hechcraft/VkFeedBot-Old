<?php

namespace App\Posts;

class Friend extends VKPost
{
    public function getMessage()
    {

        $firstPartPath = 'https://api.vk.com/method/users.get?user_ids=';
        $secondPartPath = '&fields=bdate&v=5.101&access_token=';

        $idUrFriend = $this->getIdUrFriend($this->postCount);
        $idAddFriend = $this->getIdAddFriend($this->postCount);
        $dataAboutUrFriend = json_decode(file_get_contents($firstPartPath
            . $idUrFriend . $secondPartPath . env('VK_TOKEN')));
        $lastNameUrFriend = data_get($dataAboutUrFriend, "response.0.last_name");
        $firstNameUrFriend = data_get($dataAboutUrFriend, "response.0.first_name");
        $dataAboutAddFriend = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_ids='
            . $idAddFriend . '&fields=bdate&v=5.101&access_token=' . env('VK_TOKEN')));
        $lastNameAddFriend = data_get($dataAboutAddFriend, "response.0.last_name");
        $firstNameAddFriend = data_get($dataAboutAddFriend, "response.0.first_name");
        return "{$firstNameUrFriend} {$lastNameUrFriend} добавил в друзья {$firstNameAddFriend} {$lastNameAddFriend}";
    }
}