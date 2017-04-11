<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateAdContentsTable
 * -----------------------
 * Migration to create the table 'ad_contents'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateAdContentsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('ad_contents', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('ad_id');
            $table->string('file');
            $table->string('text', config('validation.ad.text.max'))->nullable();
            $table->text('link')->nullable();
            $table->unsignedInteger('views');
            $table->unsignedInteger('clicks');
            $table->string('cta_label', config('validation.ad.label.max'))->nullable();

            $table->foreign('ad_id')
                  ->references('id')
                  ->on('ads')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('ad_contents');
    }
}
