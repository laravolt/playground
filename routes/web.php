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

Route::redirect('/', 'auth/login');

Route::get('contact-form', 'ContactFormController@create')->name('contact-form.create');
Route::post('contact-form', 'ContactFormController@store')->name('contact-form.store');

Route::prefix('admin')->namespace('Admin')->as('admin.')->group(function () {
    Route::get('contact-form', 'ContactFormController@index')->name('contact-form.index');
});
