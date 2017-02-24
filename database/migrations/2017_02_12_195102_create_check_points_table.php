<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckPointsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
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
            $table->string('country', config('validation.check_point.country.max'))->nullable();
            $table->string('postcode', config('validation.check_point.postcode.max'))->nullable();
            $table->string('city', config('validation.check_point.city.max'))->nullable();
            $table->string('street', config('validation.check_point.street.max'))->nullable();
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
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('check_points');
    }
}
