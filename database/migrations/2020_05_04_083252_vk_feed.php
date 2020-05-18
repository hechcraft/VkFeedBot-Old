<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VkFeed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vk_feed', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('telegram_id');
            $table->json('post_json');
            $table->string('md5_hash_post');
            $table->unsignedInteger('import_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vk_feed');
    }
}
