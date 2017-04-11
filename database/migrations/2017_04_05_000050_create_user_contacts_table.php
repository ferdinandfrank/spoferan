<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateUserContactsTable
 * -----------------------
 * Migration to create the table 'user_contacts'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateUserContactsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id')->primary();
            $table->string('phone', config('validation.phone.max'))->nullable();
            $table->string('mobile', config('validation.phone.max'))->nullable();
            $table->string('country', config('validation.country.max'))->nullable();
            $table->string('state', config('validation.state.max'))->nullable();
            $table->string('postcode', config('validation.postcode.max'))->nullable();
            $table->string('city', config('validation.city.max'))->nullable();
            $table->string('street', config('validation.street.max'))->nullable();

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
        Schema::dropIfExists('user_contacts');
    }
}