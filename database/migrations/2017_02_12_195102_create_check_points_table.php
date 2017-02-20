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
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('position')->default(0);
            $table->string('title', config('validation.check_point.title.max'));
            $table->float('latitude');
            $table->float('longitude');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('street')->nullable();
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
