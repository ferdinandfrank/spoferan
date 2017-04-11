<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateEventLabelsTable
 * -----------------------
 * Migration to create the table 'event_labels'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateEventLabelsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('event_labels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('label_id');

            $table->foreign('event_id')
                  ->references('id')
                  ->on('events')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('label_id')
                  ->references('id')
                  ->on('labels')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->primary(['event_id', 'label_id']);
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('event_labels');
    }
}
