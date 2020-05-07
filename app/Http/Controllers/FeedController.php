<?php

namespace App\Http\Controllers;

use App\VkFeed;
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


        $test = DB::table('vk_feed')->select('post_json')
            ->where('telegram_id', $bot->getUser()->getId())->get();
        foreach ($test as $item) {
            $jsonTest = json_decode($item->post_json);
            \Log::info(print_r($jsonTest->date, true));
        }
    }
}
