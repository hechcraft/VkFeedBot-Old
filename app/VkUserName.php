<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VkUserName extends Model
{
    protected $table = 'vk_user_name';

    public $timestamps = false;

    protected $fillable = [
        'vk_name_user',
        'vk_id_user',
        'telegram_id',
        'import_id'
    ];

    public function import()
    {
        return $this->belongsTo(Import::class);
    }
}
