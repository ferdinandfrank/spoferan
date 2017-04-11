<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateClubsTable
 * -----------------------
 * Migration to create the table 'clubs'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateClubsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('clubs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('parent_club_id');
            $table->string('title', config('validation.club.title.max'))->unique();
            $table->string('slug', config('validation.slug.max'))->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('sport_type_id');
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->boolean('privacy')->default(false);
            $table->boolean('verified')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sport_type_id')
                  ->references('id')
                  ->on('sport_types')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('parent_club_id')
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
        Schema::dropIfExists('clubs');
    }
}
