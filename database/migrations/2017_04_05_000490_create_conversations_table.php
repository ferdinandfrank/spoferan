<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateConversationsTable
 * -----------------------
 * Migration to create the table 'target_group_locations'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateConversationsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('conversations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', config('validation.conversation.title.max'))->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('conversations');
    }
}
