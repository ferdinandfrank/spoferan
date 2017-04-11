<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateAdsTable
 * -----------------------
 * Migration to create the table 'ads'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateAdsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('ads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('ad_format_id');
            $table->unsignedInteger('event_id')->nullable();
            $table->string('title', config('validation.ad.title.max'));
            $table->unsignedInteger('price');
            $table->unsignedInteger('budget');
            $table->string('budget_type', config('validation.ad.budget_type.max'));
            $table->dateTime('start');
            $table->dateTime('end');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('company_id')
                  ->references('user_id')
                  ->on('companies')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('ad_format_id')
                  ->references('id')
                  ->on('ad_formats')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('event_id')
                  ->references('id')
                  ->on('events')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('ads');
    }
}
