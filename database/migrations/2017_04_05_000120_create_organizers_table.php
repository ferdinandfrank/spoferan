<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateOrganizersTable
 * -----------------------
 * Migration to create the table 'organizers'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateOrganizersTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('organizers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id')->primary();
            $table->string('name', config('validation.organizer.name.max'))->unique();
            $table->string('slug', config('validation.slug.max'))->unique();
            $table->text('description')->nullable();

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
        Schema::dropIfExists('organizers');
    }
}
