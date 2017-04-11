<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateCompaniesTable
 * -----------------------
 * Migration to create the table 'companies'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateCompaniesTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('companies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id')->primary();
            $table->string('name', config('validation.organizer.name.max'))->unique();
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
        Schema::dropIfExists('companies');
    }
}
