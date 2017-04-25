<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateJobsTable
 * -----------------------
 * Migration to create the table 'jobs'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateJobsTable extends Migration {

    /**
     * Runs the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue', 190);
            $table->longText('payload');
            $table->tinyInteger('attempts')->unsigned();
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');

            $table->index(['queue', 'reserved_at']);
        });
    }

    /**
     * Reverses the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('jobs');
    }
}
