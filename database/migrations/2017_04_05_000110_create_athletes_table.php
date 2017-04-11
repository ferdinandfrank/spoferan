<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateAthletesTable
 * -----------------------
 * Migration to create the table 'athletes'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateAthletesTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('athletes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id')->primary();
            $table->string('title', config('validation.athlete.title.max'))->nullable();
            $table->string('first_name', config('validation.athlete.first_name.max'));
            $table->string('last_name', config('validation.athlete.last_name.max'));
            $table->string('slug', config('validation.slug.max'))->unique();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['m', 'w'])->default('m');
            $table->unsignedInteger('sport_type_id')->default('1');
            $table->string('starter_number', config('validation.starter_number.max'))->unique();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('sport_type_id')
                  ->references('id')
                  ->on('sport_types')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('athletes');
    }
}
