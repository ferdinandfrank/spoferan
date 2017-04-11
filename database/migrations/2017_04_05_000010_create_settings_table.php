<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateSettingsTable
 * -----------------------
 * Migration to create the table 'settings'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateSettingsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('key', config('validation.settings.key.max'))->unique();
            $table->text('value')->nullable();
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('settings');
    }
}
