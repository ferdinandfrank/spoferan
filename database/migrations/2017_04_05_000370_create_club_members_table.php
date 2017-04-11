<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateClubMembersTable
 * -----------------------
 * Migration to create the table 'club_members'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateClubMembersTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('club_members', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('club_id');
            $table->unsignedInteger('athlete_id');
            $table->unsignedInteger('club_role_id');
            $table->timestamps();

            $table->foreign('club_id')
                  ->references('id')
                  ->on('clubs')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('athlete_id')
                  ->references('user_id')
                  ->on('athletes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('club_role_id')
                  ->references('id')
                  ->on('club_roles')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('club_members');
    }
}
