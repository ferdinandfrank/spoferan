<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateEventsTable
 * -----------------------
 * Migration to create the table 'events'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateEventsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('events', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('organizer_id');
            $table->unsignedInteger('event_group_id')->nullable();
            $table->unsignedInteger('parent_event_id')->nullable();
            $table->string('title', config('validation.event.title.max'));
            $table->string('slug', config('validation.slug.max'))->unique();
            $table->string('description_short', config('validation.event.description_short.max'));
            $table->text('description');
            $table->string('email', config('validation.email.max'))->nullable();
            $table->string('phone', config('validation.phone.max'))->nullable();
            $table->string('cover')->nullable();
            $table->unsignedInteger('sport_type_id');
            $table->boolean('published')->default(false);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('country', config('validation.country.max'));
            $table->string('state', config('validation.state.max'));
            $table->string('postcode', config('validation.postcode.max'));
            $table->string('city', config('validation.city.max'));
            $table->string('street', config('validation.street.max'));
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

            $table->foreign('event_group_id')
                  ->references('id')
                  ->on('event_groups')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('events');
    }
}
