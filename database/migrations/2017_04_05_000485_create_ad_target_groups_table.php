<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateAdTargetGroupsTable
 * -----------------------
 * Migration to create the table 'ad_target_groups'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateAdTargetGroupsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('ad_target_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('target_group_id');
            $table->unsignedInteger('ad_id');

            $table->foreign('target_group_id')
                  ->references('id')
                  ->on('target_groups')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('ad_id')
                  ->references('id')
                  ->on('ads')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->primary(['target_group_id', 'ad_id']);
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('ad_target_groups');
    }
}
