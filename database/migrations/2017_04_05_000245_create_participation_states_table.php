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
class CreateParticipationStatesTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('participation_states', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', config('validation.participation_state.label.max'))->unique();
            $table->boolean('selectable')->default(true);
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('participation_states');
    }
}
