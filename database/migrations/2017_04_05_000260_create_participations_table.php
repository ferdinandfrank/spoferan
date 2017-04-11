<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateParticipationsTable
 * -----------------------
 * Migration to create the table 'participations'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateParticipationsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('participations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('starter_number', config('validation.starter_number.max'));
            $table->unsignedInteger('participation_class_id');
            $table->unsignedInteger('athlete_id');
            $table->unsignedInteger('club_id')->nullable();
            $table->unsignedInteger('participation_state_id')->default(1);
            $table->boolean('privacy')->default(false);
            $table->unsignedInteger('rank')->nullable();
            $table->text('description')->nullable();
            $table->text('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('athlete_id')
                  ->references('user_id')
                  ->on('athletes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('participation_class_id')
                  ->references('id')
                  ->on('participation_classes')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('participation_state_id')
                  ->references('id')
                  ->on('participation_states')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('participations');
    }
}
