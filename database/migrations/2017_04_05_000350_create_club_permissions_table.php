<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateClubPermissionsTable
 * -----------------------
 * Migration to create the table 'club_permissions'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateClubPermissionsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('club_permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', config('validation.permission.label.max'))->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('club_permissions');
    }
}
