<?php


namespace App\Post;


use Illuminate\Support\Facades\DB;

class Friend extends VkPost
{
    public function getMessage()
    {
        $user_full_name = DB::table('vk_user_name')->select('vk_id_user', 'vk_name_user')
            ->where('telegram_id', $this->telegramId)->get();

        $fullNameUrFriend = '';
        $fullNameAddFriend = '';
        foreach ($user_full_name as $user_name) {
            if ($user_name->vk_id_user == $this->getIdUrFriend()) {
                $fullNameUrFriend = $user_name->vk_name_user;
            }

            if ($user_name->vk_id_user == $this->getIdAddFriend()) {
                $fullNameAddFriend = $user_name->vk_name_user;
            }
        }
        return "$fullNameUrFriend добавил(а) в друзья $fullNameAddFriend";
    }
}