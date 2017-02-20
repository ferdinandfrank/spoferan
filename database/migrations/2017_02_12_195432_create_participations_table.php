<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('participations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('starter_number');
            $table->unsignedInteger('participation_class_id');
            $table->unsignedInteger('athlete_id');
            $table->unsignedInteger('participation_state_id')->default(1);
            $table->boolean('privacy')->default(false);
            $table->unsignedInteger('rank')->nullable();
            $table->time('time')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('athlete_id')
                  ->references('user_id')
                  ->on('athletes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('participation_class_id')
                  ->references('id')
                  ->on('participation_classes')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('participation_state_id')
                  ->references('id')
                  ->on('participation_states')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('participations');
    }
}
