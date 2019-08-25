<?php

namespace App\Posts;

class Friend extends VKPost
{
    public function getMessage()
    {
        $idUrFriend = data_get($this->response, 'response.items.0.source_id');
        $idAddFriend = data_get($this->response, 'response.items.0.friends.items.0.user_id');
        dd($idAddFriend,$idUrFriend);
        $dataAboutUrFriend = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_ids='
            . $idUrFriend . '&fields=bdate&v=5.101&access_token=' . config('service.vk.token')));
        $lastNameUrFriend = data_get($dataAboutUrFriend, 'response.0.last_name');
        $firstNameUrFriend = data_get($dataAboutUrFriend, 'response.0.first_name');
        $dataAboutAddFriend = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_ids='
            . $idAddFriend . '&fields=bdate&v=5.101&access_token=' . config('service.vk.token')));
        $lastNameAddFriend = data_get($dataAboutAddFriend, 'response.0.last_name');
        $firstNameAddFriend = data_get($dataAboutAddFriend, 'response.0.first_name');
        return "{$firstNameUrFriend} {$lastNameUrFriend} добавил в друзья {$firstNameAddFriend} {$lastNameAddFriend}";
    }
}