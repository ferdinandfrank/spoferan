<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateAdminRolesTable
 * -----------------------
 * Migration to create the table 'admin_roles'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateAdminRolesTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('admin_id');
            $table->unsignedInteger('role_id');

            $table->foreign('admin_id')
                  ->references('user_id')
                  ->on('admins')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->primary(['admin_id', 'role_id']);
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('admin_roles');
    }
}
