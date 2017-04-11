<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateVisitClassesTable
 * -----------------------
 * Migration to create the table 'visit_classes'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateVisitClassesTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('visit_classes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->string('title', config('validation.visit_class.title.max'));
            $table->text('description')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedInteger('restr_limit')->nullable();
            $table->dateTime('register_date');
            $table->dateTime('unregister_date');
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
        Schema::dropIfExists('visit_classes');
    }
}
