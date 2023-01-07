<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function (){
    Route::get('/','App\Http\Controllers\ContactController@list')->name('home');
    Route::post('contact/store', 'App\Http\Controllers\ContactController@store')->name('contact.store');
    Route::get('contact/edit/{id}', 'App\Http\Controllers\ContactController@edit')->name('contact.edit');
    Route::get('admin/dashboard', 'App\Http\Controllers\AdminController@index');
    Route::post('contact/update/', 'App\Http\Controllers\ContactController@update')->name('contact.update');
    Route::delete('contact/delete/', 'App\Http\Controllers\ContactController@destroy')->name('contact.delete');
});
Route::get('/spa', 'App\Http\Controllers\FormController@view')->name('form.view');
Route::get('/spa/list', 'App\Http\Controllers\FormController@list');
Route::post('/spa/store', 'App\Http\Controllers\FormController@store')->name('form.store');
Route::get('/spa/edit/{id}', 'App\Http\Controllers\FormController@edit')->name('form.edit');
Route::post('/spa/update/', 'App\Http\Controllers\FormController@update');
Route::delete('/spa/delete/', 'App\Http\Controllers\FormController@destroy');
Route::get('/spa/search', 'App\Http\Controllers\FormController@search')->name('spa.search');
Route::get('/spa/modalview/{id}', 'App\Http\Controllers\FormController@modalview')->name('form.modalview');

Route::get('/spa/email/', 'App\Http\Controllers\FormController@email');

Route::get('/spa/optin/confirmaiton/{id}', 'App\Http\Controllers\FormController@optin');


Route::get('/spa/testlist/{id}', 'App\Http\Controllers\FormController@testlist');

Route::post('/spa/formmeta', 'App\Http\Controllers\FormController@formmeta');
Route::get('/spa/formmetavalue/{id}', 'App\Http\Controllers\FormController@formmetavalue');

Route::get('/token', function () {
    return csrf_token();
});


Route::get('contact', 'App\Http\Controllers\ContactController@contact')->name('contact');
Route::get('about', 'App\Http\Controllers\AdminController@about')->name('about');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
