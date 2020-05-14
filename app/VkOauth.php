<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VkOauth extends Model
{
    protected $table = 'vk_oauth';

    public $timestamps = false;

    protected $fillable = [
        'vk_token',
        'vk_id',
        'telegram_id'
    ];

    public function posts()
    {
        return $this->hasMany(VkFeed::class, 'telegram_id', 'telegram_id');
    }
}
