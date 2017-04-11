<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreatePasswordResetsTable
 * -----------------------
 * Migration to create the table 'password_resets'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreatePasswordResetsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('email', config('validation.email.max'))->index();
            $table->string('token', config('validation.confirmation_token.max'))->index();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('password_resets');
    }
}
