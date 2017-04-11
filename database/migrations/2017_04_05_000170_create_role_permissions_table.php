<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateRolePermissionsTable
 * -----------------------
 * Migration to create the table 'role_permissions'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateRolePermissionsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')
                  ->references('id')
                  ->on('permissions')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('role_permissions');
    }
}
