<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

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

Auth::routes();

Route::get('/autologin/{token}', 'AutoLoginController@autologin')->name('autologin');

Route::middleware('auth')->group(function() {

    Route::get('/', function () {
        return redirect(route('tickets.index'));
    })->name('home');

    Route::resource('tickets', 'TicketsController');
    Route::post('tickets/{ticket}/close', 'TicketsController@close')->name('tickets.close');
    Route::post('tickets/{ticket}/assign', 'TicketsController@assignManager')->name('tickets.assign');

    Route::resource('tickets/{ticket}/comments', 'CommentsController')->except(['index', 'show']);
    Route::get('print/option', 'TicketsController@printOption')->name('option');
    Route::get('/print/{date1}/{date2}', 'TicketsController@reportDate')->name('print');
    Route::resource('/locations', 'LocationsController');
    Route::get('tickets/{ticket}/add-image', 'ImagesController@add')->name('image.add');
    Route::resource('tickets/{ticket}/images', 'ImagesController')->except(['index', 'show']);

    Route::resource('users', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
