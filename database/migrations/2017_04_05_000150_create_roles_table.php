<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateRolesTable
 * -----------------------
 * Migration to create the table 'roles'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateRolesTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', config('validation.role.label.max'))->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('roles');
    }
}
