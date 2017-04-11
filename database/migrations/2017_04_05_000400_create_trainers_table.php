<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateTrainersTable
 * -----------------------
 * Migration to create the table 'trainers'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateTrainersTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('trainers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id')->primary();
            $table->unsignedInteger('sport_type_id');
            $table->text('description')->nullable();
            $table->boolean('verified')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sport_type_id')
                  ->references('id')
                  ->on('sport_types')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('trainers');
    }
}
