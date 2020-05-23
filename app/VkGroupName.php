<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VkGroupName extends Model
{
    protected $table = 'vk_group_name';

    public $timestamps = false;

    protected $fillable = [
        'vk_group_name',
        'vk_id_group',
        'import_id'
    ];

    public function import()
    {
        return $this->belongsTo(Import::class);
    }
}
