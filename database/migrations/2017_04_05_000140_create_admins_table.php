<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateAdminsTable
 * -----------------------
 * Migration to create the table 'admins'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateAdminsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('admins', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id')->primary();
            $table->string('first_name', config('validation.admin.first_name.max'));
            $table->string('last_name', config('validation.admin.last_name.max'));
            $table->string('display_name', config('validation.admin.display_name.max'));
            $table->string('slug', config('validation.slug.max'))->unique();

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
        Schema::dropIfExists('admins');
    }
}
