<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateAdFormatsTable
 * -----------------------
 * Migration to create the table 'ad_formats'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateAdFormatsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('ad_formats', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('ad_placement_id');
            $table->string('label', config('validation.ad_placement.label.max'));
            $table->unsignedInteger('base_price');
            $table->timestamps();

            $table->foreign('ad_placement_id')
                  ->references('id')
                  ->on('ad_placements')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('ad_formats');
    }
}
