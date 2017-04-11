<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateVisitsTable
 * -----------------------
 * Migration to create the table 'visits'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateVisitsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('visits', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('athlete_id');
            $table->unsignedInteger('visit_class_id');
            $table->boolean('privacy')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('athlete_id')
                  ->references('user_id')
                  ->on('athletes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('visit_class_id')
                  ->references('id')
                  ->on('visit_classes')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('visits');
    }
}
