<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VkMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vk_oauth', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vk_token');
            $table->string('vk_id');
            $table->string('telegram_id');
            $table->longText('all_md5')->nullable();
            $table->unique(['vk_id', 'telegram_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vk_oauth');
    }
}
