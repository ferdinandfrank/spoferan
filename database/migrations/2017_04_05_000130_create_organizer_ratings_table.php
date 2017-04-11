<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateOrganizerRatingsTable
 * -----------------------
 * Migration to create the table 'organizer_ratings'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateOrganizerRatingsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('organizer_ratings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('organizer_id');
            $table->unsignedInteger('athlete_id');
            $table->tinyInteger('rating');
            $table->text('description')->nullable();
            $table->boolean('privacy')->default(false);
            $table->timestamps();

            $table->foreign('athlete_id')
                  ->references('user_id')
                  ->on('athletes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('organizer_id')
                  ->references('user_id')
                  ->on('organizers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->primary(['organizer_id', 'athlete_id']);
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('organizer_ratings');
    }
}
