<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VkPost extends Model
{
    protected $table = 'vk_oauth';

    public $timestamps = false;

    protected $fillable = [
        'vk_token',
        'vk_id',
        'telegram_id'
    ];
}