<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateMessagesTable
 * -----------------------
 * Migration to create the table 'messages'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateMessagesTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('conversation_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->text('body');
            $table->timestamps();

            $table->foreign('conversation_id')
                  ->references('id')
                  ->on('conversations')
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
        Schema::dropIfExists('messages');
    }
}
