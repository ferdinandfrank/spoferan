<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateSocialMediasTable
 * -----------------------
 * Migration to create the table 'social_medias'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateSocialMediasTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('social_medias', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->morphs('holder');
            $table->string('website', config('validation.facebook.max'))->nullable();
            $table->string('facebook', config('validation.facebook.max'))->nullable();
            $table->string('instagram', config('validation.instagram.max'))->nullable();
            $table->string('youtube', config('validation.youtube.max'))->nullable();
            $table->string('snapchat', config('validation.snapchat.max'))->nullable();
            $table->string('twitter', config('validation.twitter.max'))->nullable();
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('social_medias');
    }
}