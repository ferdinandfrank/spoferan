<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id')->primary();
            $table->boolean('receive_ads')->default(true);
            $table->boolean('privacy_profile')->default(false);
            $table->boolean('privacy_address')->default(false);
            $table->boolean('privacy_event_history')->default(false);

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        DB::unprepared('
            CREATE TRIGGER INSERT_USER_SETTINGS_ON_USER_INSERT
            AFTER INSERT ON `users`
            FOR EACH ROW
            BEGIN
                INSERT INTO `user_settings` (`user_id`)
                VALUES (NEW.`id`);
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::unprepared('DROP TRIGGER `INSERT_USER_SETTINGS_ON_USER_INSERT`');
        Schema::dropIfExists('user_settings');
    }
}
