<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateLabelsTable
 * -----------------------
 * Migration to create the table 'labels'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateLabelsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('labels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', config('validation.label.label.max'))->unique();
            $table->string('icon')->nullable();
            $table->boolean('selectable')->default(false);
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('labels');
    }
}
