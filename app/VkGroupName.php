<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VkGroupName extends Model
{
    protected $table = 'vk_group_name';

    public $timestamps = false;

    protected $fillable = [
        'vk_group_user',
        'vk_id_group',
        'telegram_id'
    ];
}
