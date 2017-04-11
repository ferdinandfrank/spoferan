<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateClubRolePermissionsTable
 * -----------------------
 * Migration to create the table 'club_role_permissions'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateClubRolePermissionsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('club_role_permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('club_permission_id');
            $table->unsignedInteger('club_role_id');

            $table->foreign('club_permission_id')
                  ->references('id')
                  ->on('club_permissions')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('club_role_id')
                  ->references('id')
                  ->on('club_roles')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->primary(['club_permission_id', 'club_role_id']);
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('club_role_permissions');
    }
}
