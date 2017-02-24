<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipationClassesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('participation_classes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->string('title', config('validation.participation_class.title.max'));
            $table->text('description')->nullable();
            $table->float('entry_fee', 5, 2);
            $table->boolean('privacy')->default(false);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('register_date');
            $table->dateTime('unregister_date');
            $table->unsignedInteger('restr_limit')->nullable();
            $table->dateTime('restr_birth_date_min')->nullable();
            $table->dateTime('restr_birth_date_max')->nullable();
            $table->enum('restr_gender', ['m', 'w'])->nullable();
            $table->string('restr_country')->nullable();
            $table->string('restr_city')->nullable();
            $table->unsignedInteger('restr_postcode')->nullable();
            $table->timestamps();

            $table->foreign('event_id')
                  ->references('id')
                  ->on('events')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('participation_classes');
    }
}
