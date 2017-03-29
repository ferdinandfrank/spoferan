<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id')->primary();
            $table->string('stripe_id')->nullable();
            $table->boolean('stripe_active')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        DB::unprepared('
            CREATE TRIGGER INSERT_PAYMENT_DETAILS_ON_USER_INSERT
            AFTER INSERT ON `users`
            FOR EACH ROW
            BEGIN
                INSERT INTO `payment_details` (`user_id`)
                VALUES (NEW.`id`);
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::unprepared('DROP TRIGGER `INSERT_PAYMENT_DETAILS_ON_USER_INSERT`');
        Schema::dropIfExists('payment_details');
    }
}
