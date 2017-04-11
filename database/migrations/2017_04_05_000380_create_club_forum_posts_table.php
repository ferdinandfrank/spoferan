<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateClubForumPostsTable
 * -----------------------
 * Migration to create the table 'club_forum_posts'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateClubForumPostsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('club_forum_posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('club_id');
            $table->unsignedInteger('creator_id')->nullable();
            $table->string('title', config('validation.club_forum_posts.title.max'))->unique();
            $table->text('text');
            $table->timestamps();

            $table->foreign('club_id')
                  ->references('id')
                  ->on('clubs')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('creator_id')
                  ->references('id')
                  ->on('club_members')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('club_forum_posts');
    }
}
