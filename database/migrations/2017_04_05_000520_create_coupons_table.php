<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateCouponsTable
 * -----------------------
 * Migration to create the table 'coupons'.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class CreateCouponsTable extends Migration {

    /**
     * Runs the migrations.
     */
    public function up() {
        Schema::create('coupons', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code', config('validation.coupon.code.max'))->unique();
            $table->unsignedInteger('creator_id')->nullable();
            $table->unsignedInteger('event_id')->nullable();
            $table->unsignedInteger('amount_off')->nullable();
            $table->unsignedTinyInteger('percent_off')->nullable();
            $table->dateTime('redeem_start')->nullable();
            $table->dateTime('redeem_end')->nullable();
            $table->string('type', config('validation.coupon.type.max'));
            $table->unsignedInteger('max_redemptions')->nullable();
            $table->unsignedInteger('times_redeemed')->default(0);
            $table->boolean('valid')->default(true);
            $table->timestamps();

            $table->foreign('creator_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverses the migrations.
     */
    public function down() {
        Schema::dropIfExists('coupons');
    }
}
