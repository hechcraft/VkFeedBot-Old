<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateImportsTable
 *
 *
 */
class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('telegram_id');
            $table->integer('posts_count')->nullable();
            $table->timestamps();
        });

        Schema::table('vk_feed', function (Blueprint $table) {
            $table->unsignedInteger('import_id');
        });

        Schema::table('vk_group_name', function (Blueprint $table) {
            $table->unsignedInteger('import_id');
        });

        Schema::table('vk_user_name', function (Blueprint $table) {
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
        Schema::dropIfExists('imports');

        Schema::table('vk_feed', function (Blueprint $table) {
            $table->dropColumn('import_id');
        });

        Schema::table('vk_group_name', function (Blueprint $table) {
            $table->dropColumn('import_id');
        });

        Schema::table('vk_user_name', function (Blueprint $table) {
            $table->dropColumn('import_id');
        });
    }
}
