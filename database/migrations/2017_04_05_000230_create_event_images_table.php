<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateEventImagesTable
 * -----------------------
 * Migration to create the table 'event_images'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateEventImagesTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('event_images', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('album_id');
            $table->string('image');
            $table->string('title', config('validation.image.title.max'))->nullable();
            $table->text('description')->nullable();
            $table->boolean('privacy')->default(false);
            $table->timestamps();

            $table->foreign('event_id')
                  ->references('id')
                  ->on('events')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('album_id')
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
        Schema::dropIfExists('event_images');
    }
}
