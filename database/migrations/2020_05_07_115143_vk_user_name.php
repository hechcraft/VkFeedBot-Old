<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VkUserName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vk_user_name', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('telegram_id');
            $table->string('vk_id_user');
            $table->string('vk_name_user');
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
        Schema::dropIfExists('vk_user_name');
    }
}
