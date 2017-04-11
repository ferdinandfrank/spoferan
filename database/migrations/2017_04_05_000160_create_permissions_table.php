<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreatePermissionsTable
 * -----------------------
 * Migration to create the table 'permissions'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreatePermissionsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', config('validation.permission.label.max'))->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('permissions');
    }
}
