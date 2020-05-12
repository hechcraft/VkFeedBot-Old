<?php

namespace App\Http\Controllers;

use App\VkFeed;
use App\VkGroupName;
use App\VkUserName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class FeedController extends Controller
{

    private function saveData($data, $postJson, $md5String)
    {
        $data->post_json = $postJson;
        $data->md5_hash_post = $md5String;
        $data->save();
    }

    public function profilesStore($bot, $response)
    {
        $groupsData = data_get($response, 'response.groups');
        foreach ($groupsData as $item) {
            $groupNameData = new VkGroupName;
            $groupNameData->telegram_id = $bot->getUser()->getId();
            $groupNameData->vk_id_group = $item->id;
            $groupNameData->vk_group_name = $item->name;
//            $groupNameData->save();
        }


        $usersData = data_get($response, 'response.profiles');
        foreach ($usersData as $item) {
            $userNameData = new VkUserName;
            $userNameData->telegram_id = $bot->getUser()->getId();
            $userNameData->vk_id_user = $item->id;
            $userNameData->vk_name_user = $item->first_name . ' ' . $item->last_name;
//            $userNameData->save();
        }
    }

    public function store($bot, $item)
    {
        $data = new VkFeed;
        $data->telegram_id = $bot->getUser()->getId();


        $md5Date = $item->date;
        if (isset($item->text)) {
            $md5Text = $item->text;
        } else {
            $md5Text = '';
        }
        $md5String = md5($md5Date . $md5Text);

        $postJson = json_encode($item);
        $feedData = DB::table('vk_feed')->orderBy('id', 'desc')
            ->select('post_json', 'md5_hash_post')
            ->where('telegram_id', $bot->getUser()->getId())->first();

        if (is_null($feedData)) {
//            $this->saveData($data, $postJson, $md5String);
            return;
        }

        if ($feedData->md5_hash_post === $md5String) {
            return;
        }

//        $this->saveData($data, $postJson, $md5String);
    }
}
