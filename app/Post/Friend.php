<?php


namespace App\Post;


use App\VkUserName;
use Illuminate\Support\Facades\DB;

class Friend extends VkPost
{
    public function getMessage()
    {
        $userFullNmae = VkUserName::select('vk_id_user', 'vk_name_user')
            ->where('telegram_id', $this->telegramId)->get();

        $fullNameUrFriend = '';
        $fullNameAddFriend = '';
        foreach ($userFullNmae as $userName) {
            if ($userName->vk_id_user == $this->getIdUrFriend()) {
                $fullNameUrFriend = $userName->vk_name_user;
            }

            if ($userName->vk_id_user == $this->getIdAddFriend()) {
                $fullNameAddFriend = $userName->vk_name_user;
            }
        }
        return "$fullNameUrFriend добавил(а) в друзья $fullNameAddFriend";
    }
}