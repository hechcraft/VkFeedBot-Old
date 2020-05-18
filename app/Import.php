<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(VkUserName::class);
    }

    public function groups()
    {
        return $this->hasMany(VkGroupName::class);
    }

    public function posts()
    {
        return $this->hasMany(VkFeed::class);
    }
}
