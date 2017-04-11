<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateUserSettingsTable
 * -----------------------
 * Migration to create the table 'user_settings'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateUserSettingsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id')->primary();
            $table->boolean('receive_newsletter')->default(true);
            $table->boolean('privacy_profile')->default(false);
            $table->boolean('privacy_address')->default(false);
            $table->boolean('privacy_event_history')->default(false);

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
        Schema::dropIfExists('user_settings');
    }
}
