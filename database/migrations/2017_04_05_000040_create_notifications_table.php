<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateNotificationsTable
 * -----------------------
 * Migration to create the table 'notifications'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateNotificationsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('notifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id')->primary();
            $table->morphs('notifiable');
            $table->string('type');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('notifications');
    }
}
