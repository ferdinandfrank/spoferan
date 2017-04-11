<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateAdContentsTable
 * -----------------------
 * Migration to create the table 'ad_content_clicks'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateAdContentClicksTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('ad_content_clicks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('ad_content_id');
            $table->unsignedInteger('user_id')->nullable();

            $table->foreign('ad_content_id')
                  ->references('id')
                  ->on('ad_contents')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('ad_content_clicks');
    }
}
