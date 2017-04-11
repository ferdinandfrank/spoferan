<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateTargetGroupsTable
 * -----------------------
 * Migration to create the table 'target_groups'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateTargetGroupsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('target_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->string('title', config('validation.target_group.title.max'));
            $table->unsignedInteger('sport_type_id')->nullable();
            $table->enum('gender', ['m', 'w'])->nullable();
            $table->unsignedInteger('age_min')->nullable();
            $table->unsignedInteger('age_max')->nullable();
            $table->boolean('club_members')->nullable();
            $table->timestamps();

            $table->foreign('company_id')
                  ->references('user_id')
                  ->on('companies')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('sport_type_id')
                  ->references('id')
                  ->on('sport_types')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('target_groups');
    }
}
