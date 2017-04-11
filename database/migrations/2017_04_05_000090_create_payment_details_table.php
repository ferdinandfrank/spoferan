<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreatePaymentDetailsTable
 * -----------------------
 * Migration to create the table 'payment_details'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreatePaymentDetailsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('stripe_id', config('validation.stripe_id.max'))->nullable();
            $table->string('stripe_object', config('validation.stripe_id.max'))->nullable();
            $table->boolean('stripe_active')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('payment_details');
    }
}
