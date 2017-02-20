<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', config('validation.user.email.max'))->unique();
            $table->string('password', config('validation.user.password.max'));
            $table->string('avatar')->nullable();
            $table->unsignedInteger('user_type')->default(config('starmee.user_type.athlete'));
            $table->string('country', config('validation.user.country.max'))->nullable();
            $table->string('postcode', config('validation.user.postcode.max'))->nullable();
            $table->string('city', config('validation.user.city.max'))->nullable();
            $table->string('street', config('validation.user.street.max'))->nullable();
            $table->string('phone', config('validation.user.phone.max'))->nullable();
            $table->string('confirmation_token', config('validation.user.confirmation_token.max'))->nullable()->index();
            $table->boolean('confirmed')->default(false);
            $table->boolean('verified')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }
}
