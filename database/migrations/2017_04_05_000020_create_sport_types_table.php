<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateSportTypesTable
 * -----------------------
 * Migration to create the table 'sport_types'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateSportTypesTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('sport_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', config('validation.sport_type.label.max'))->unique();
            $table->string('slug', config('validation.slug.max'))->unique();
            $table->string('icon')->nullable();
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('sport_types');
    }
}
