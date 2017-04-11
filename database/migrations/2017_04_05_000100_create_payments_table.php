<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreatePaymentsTable
 * -----------------------
 * Migration to create the table 'payments'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreatePaymentsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->morphs('payable_id');
            $table->string('payment_type', config('validation.payment_type.max'));
            $table->smallInteger('amount');
            $table->string('charge_id', config('validation.charge_id.max'))->nullable();
            $table->unsignedInteger('coupon_id')->nullable();
            $table->text('metadata')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('coupon_id')
                  ->references('id')
                  ->on('coupons')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('payments');
    }
}
