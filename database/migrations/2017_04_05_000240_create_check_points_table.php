<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateCheckPointsTable
 * -----------------------
 * Migration to create the table 'check_points'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateCheckPointsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('check_points', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('position')->default(0);
            $table->string('title', config('validation.check_point.title.max'));
            $table->float('latitude');
            $table->float('longitude');
            $table->string('country', config('validation.country.max'))->nullable();
            $table->string('postcode', config('validation.postcode.max'))->nullable();
            $table->string('city', config('validation.city.max'))->nullable();
            $table->string('street', config('validation.street.max'))->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('check_points');
    }
}
