<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateEventRatingsTable
 * -----------------------
 * Migration to create the table 'event_ratings'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateEventRatingsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('event_ratings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('event_id');
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

            $table->foreign('event_id')
                  ->references('id')
                  ->on('events')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->primary(['event_id', 'athlete_id']);
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('event_ratings');
    }
}
