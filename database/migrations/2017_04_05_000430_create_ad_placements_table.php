<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateAdPlacementsTable
 * -----------------------
 * Migration to create the table 'ad_placements'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateAdPlacementsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('ad_placements', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', config('validation.ad_placement.label.max'))->unique();
            $table->string('type', config('validation.ad_placement.type.max'));
            $table->timestamps();
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('ad_placements');
    }
}
