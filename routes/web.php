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

// Authentication Routes...
$this->get('login', 'Auth\LoginController@show')->name('login');
$this->post('login', 'Auth\LoginController@login')->name('login.post');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'UserController@create')->name('register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.post');

Route::resource('users', 'UserController');
Route::resource('events', 'EventController');
Route::get('events/{event}/participate', 'ParticipationController@create')->name('participation.create');
Route::resource('events/{event}/participation-classes', 'ParticipationClassController');
Route::get('events/{event}/{child}', 'EventController@showChild')->name('events.children.show');
Route::resource('athletes', 'AthleteController');

Route::resource('participations', 'ParticipationController');

Route::post('webhook/stripe', 'WebhooksController@handle');
