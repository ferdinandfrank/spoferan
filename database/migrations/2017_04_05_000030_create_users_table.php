<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateUsersTable
 * -----------------------
 * Migration to create the table 'users'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateUsersTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email', config('validation.email.max'))->unique();
            $table->string('password', config('validation.password.max'));
            $table->string('avatar')->nullable();
            $table->string('current_user_type', config('validation.user_type.max'))->default(config('spoferan.user_type.athlete'));
            $table->string('confirmation_token', config('validation.confirmation_token.max'))->nullable()->index();
            $table->boolean('confirmed')->default(false);
            $table->boolean('verified')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('users');
    }
}