<?php

namespace App\Http\Controllers;

use App\VkFeed;
use Illuminate\Http\Request;

class FeedController extends Controller
{

    public function store($bot, $postJson)
    {
        $data = new VkFeed;
        $data->telegram_id = $bot->getUser()->getId();
        $data->post_json = $postJson;
        $data->save();
    }
}
