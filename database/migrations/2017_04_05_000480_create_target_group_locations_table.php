<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateTargetGroupLocationsTable
 * -----------------------
 * Migration to create the table 'target_group_locations'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateTargetGroupLocationsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('target_group_locations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('target_group_id');
            $table->string('country', config('validation.country.max'))->nullable();
            $table->string('state', config('validation.state.max'))->nullable();
            $table->string('postcode', config('validation.postcode.max'))->nullable();
            $table->string('city', config('validation.city.max'))->nullable();

            $table->foreign('target_group_id')
                  ->references('id')
                  ->on('target_groups')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('target_group_locations');
    }
}
