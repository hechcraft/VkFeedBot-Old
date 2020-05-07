<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VkFeed extends Model
{
    protected $table = 'vk_feed';

    public $timestamps = false;

    protected $fillable = [
        'telegram_id',
        'post_json',
        'md5_hash_post'
    ];
}
