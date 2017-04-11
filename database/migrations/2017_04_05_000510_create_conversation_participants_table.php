<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateConversationParticipantsTable
 * -----------------------
 * Migration to create the table 'conversation_participants'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateConversationParticipantsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('conversation_participants', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('conversation_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('last_read')->nullable();
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
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('conversation_participants');
    }
}
