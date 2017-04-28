<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index')->name('index');

// TODO: Remove
Route::get('/email', function () {
    return view((new \Illuminate\Auth\Notifications\ResetPassword('bla'))->toMail('test'));
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@show')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'UserController@create')->name('register');
Route::post('users', 'UserController@store')->name('users.store');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.post');

Route::resource('events', 'EventController');
Route::get('events/{event}/participate', 'ParticipationController@create')->name('participation.create');
Route::resource('events/{event}/participation-classes', 'ParticipationClassController');
Route::get('events/{event}/{child}', 'EventController@showChild')->name('events.children.show');
Route::resource('athletes', 'AthleteController');

Route::get('events/{event}/participate', 'ParticipationController@create')->name('participations.create');
Route::get('events/{event}/participation-classes/{participationClass}/participations/{participation}', 'ParticipationController@show')->name('participations.show');
Route::get('participations/{participation}', function (\App\Models\Participation $participation) {
    return redirect()->action(
        'ParticipationController@show', [$participation->participationClass->event, $participation->participationClass, $participation]
    );
});

Route::delete('events/{event}/participation-classes/{participationClass}/participations/{participation}', 'ParticipationController@destroy')->name('participations.destroy');
Route::get('events/{event}/participations/{participation}/download', 'ParticipationController@download')->name('participations.download');
Route::get('participations', 'ParticipationController@index')->name('participations.index')->middleware('auth');
Route::post('participations', 'ParticipationController@store')->name('participations.store');


Route::post('webhook/stripe', 'WebhooksController@handleStripe');

Route::post('payment-details/{paymentDetails}', 'PaymentDetailsController@store')->name('payment_details.store');


Route::resource('coupons', 'CouponController');