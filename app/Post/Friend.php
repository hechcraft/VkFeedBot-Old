<?php


namespace App\Post;


use App\VkUserName;
use Illuminate\Support\Facades\DB;

class Friend extends VkPost
{
    public function getMessage()
    {
        $userFullName = VkUserName::pluck('vk_name_user', 'vk_id_user');

        $fullNameUrFriend = data_get($userFullName, $this->getIdUrFriend());
        $fullNameAddFriend = data_get($userFullName, $this->getIdAddFriend());

        return "$fullNameUrFriend добавил(а) в друзья $fullNameAddFriend";
    }
}