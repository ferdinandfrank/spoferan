<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateTrainingPlansTable
 * -----------------------
 * Migration to create the table 'training_plans'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateTrainingPlansTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('training_plans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('trainer_id');
            $table->unsignedInteger('sport_type_id');
            $table->string('title', config('validation.training_plan.title.max'));
            $table->text('description')->nullable();
            $table->string('file');
            $table->boolean('verified')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sport_type_id')
                  ->references('id')
                  ->on('sport_types')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('trainer_id')
                  ->references('user_id')
                  ->on('trainers')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('training_plans');
    }
}
