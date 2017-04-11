<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateParticipationClassesTable
 * -----------------------
 * Migration to create the table 'participation_classes'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateParticipationClassesTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('participation_classes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->string('title', config('validation.participation_class.title.max'));
            $table->text('description')->nullable();
            $table->unsignedInteger('price');
            $table->boolean('privacy')->default(false);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('register_date');
            $table->dateTime('unregister_date');
            $table->boolean('only_clubs')->default(false);
            $table->boolean('multiple_starts')->default(true);
            $table->unsignedInteger('restr_limit')->nullable();
            $table->dateTime('restr_birth_date_min')->nullable();
            $table->dateTime('restr_birth_date_max')->nullable();
            $table->enum('restr_gender', ['m', 'w'])->nullable();
            $table->unsignedInteger('restr_club_id')->nullable();
            $table->string('restr_country', config('validation.country.max'))->nullable();
            $table->string('restr_state', config('validation.state.max'))->nullable();
            $table->string('restr_postcode', config('validation.postcode.max'))->nullable();
            $table->timestamps();

            $table->foreign('event_id')
                  ->references('id')
                  ->on('events')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('participation_classes');
    }
}
