<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateClubForumPostAnswersTable
 * -----------------------
 * Migration to create the table 'club_forum_post_answers'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateClubForumPostAnswersTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('club_forum_post_answers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('creator_id')->nullable();
            $table->text('text');
            $table->timestamps();

            $table->foreign('post_id')
                  ->references('id')
                  ->on('club_forum_posts')
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
        Schema::dropIfExists('club_forum_post_answers');
    }
}
