<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateEventGroupsTable
 * -----------------------
 * Migration to create the table 'event_groups'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateEventGroupsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('event_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('organizer_id');
            $table->string('title', config('validation.event_group.title.max'));
            $table->string('slug', config('validation.slug.max'))->unique();
            $table->text('description');
            $table->string('cover')->nullable();
            $table->unsignedInteger('sport_type_id');
            $table->timestamps();

            $table->foreign('organizer_id')
                  ->references('user_id')
                  ->on('organizers')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

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
        Schema::dropIfExists('event_groups');
    }
}
