<?php

namespace App\Posts;

class Friend implements PostType
{
    private $TOKENVK = 'c524e7184a62f272331cacfe6807795c6442b90de9be1d3719d238840502fcef5e1df66dae681324e9484';
    use HasText;

    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getMessage()
    {
        $idUrFriend = data_get($this->response, 'response.items.0.source_id');
        $idAddFriend = data_get($this->response, 'response.items.0.friends.items.0.user_id');
        $dataAboutUrFriend = json_decode(file_get_contents($URL = 'https://api.vk.com/method/users.get?user_ids=' . $idUrFriend . '&fields=bdate&v=5.101&access_token=' . $this->TOKENVK));
        $lastNameUrFriend = data_get($dataAboutUrFriend, 'response.0.last_name');
        $firstNameUrFriend = data_get($dataAboutUrFriend, 'response.0.first_name');
        $dataAboutAddFriend = json_decode(file_get_contents($URL = 'https://api.vk.com/method/users.get?user_ids=' . $idAddFriend . '&fields=bdate&v=5.101&access_token=' . $this->TOKENVK));
        $lastNameAddFriend = data_get($dataAboutAddFriend, 'response.0.last_name');
        $firstNameAddFriend = data_get($dataAboutAddFriend, 'response.0.first_name');
        return $message = $firstNameUrFriend . ' ' . $lastNameUrFriend . ' добавил в друзья ' . $firstNameAddFriend . ' ' . $lastNameAddFriend;

    }
}