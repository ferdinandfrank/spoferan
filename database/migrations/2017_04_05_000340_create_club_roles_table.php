<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateClubRolesTable
 * -----------------------
 * Migration to create the table 'club_roles'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateClubRolesTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('club_roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('club_id');
            $table->string('label', config('validation.role.label.max'))->unique();
            $table->timestamps();

            $table->foreign('club_id')
                  ->references('id')
                  ->on('clubs')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('club_roles');
    }
}
