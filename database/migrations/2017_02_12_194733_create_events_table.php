<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('organizer_id')->index();
            $table->unsignedInteger('event_group_id')->nullable();
            $table->unsignedInteger('parent_event_id')->nullable();
            $table->string('title', config('validation.event.title.max'));
            $table->string('slug', config('validation.event.slug.max'))->unique();
            $table->string('description_short', config('validation.event.description_short.max'));
            $table->text('description');
            $table->string('email', config('validation.event.email.max'))->nullable();
            $table->string('phone', config('validation.event.phone.max'))->nullable();
            $table->string('cover')->nullable();
            $table->unsignedInteger('sport_type_id');
            $table->boolean('published')->default(false);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organizer_id')
                  ->references('user_id')
                  ->on('organizers')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('sport_type_id')
                  ->references('id')
                  ->on('sport_types')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('parent_event_id')
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
        Schema::dropIfExists('events');
    }
}
