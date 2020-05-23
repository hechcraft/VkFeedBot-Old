<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VkGroupName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vk_group_name', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vk_id_group');
            $table->string('vk_group_name');
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
        Schema::dropIfExists('vk_group_name');
    }
}
