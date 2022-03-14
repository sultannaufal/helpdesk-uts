<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/autologin/{token}', [AutoLoginController::class, 'autologin'])->name('autologin');

Route::middleware('auth')->group(function() {

    Route::get('/', function () {
        return redirect(route('tickets.index'));
    })->name('home');

    Route::controller(TicketController::class)->group(function () {
        Route::post('tickets/{ticket}/close', 'close')->name('tickets.close');
        Route::post('tickets/{ticket}/assign', 'assignManager')->name('tickets.assign');
        Route::get('print/option', 'printOption')->name('option');
        Route::get('/print/{date1}/{date2}', 'reportDate')->name('print');
    });
    Route::resource('tickets', TicketController::class);

    Route::resource('tickets/{ticket}/comments', CommentController::class)->except(['index', 'show']);
    Route::resource('/locations', LocationController::class);

    Route::get('tickets/{ticket}/add-image', [ImageController::class, 'add'])->name('image.add');
    Route::resource('tickets/{ticket}/images', ImageController::class)->except(['index', 'show']);

    Route::resource('users', UserController::class)->except(['show']);

    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'edit')->name('profile.edit');
        Route::put('profile', 'update')->name('profile.update');
        Route::put('profile/password', 'password')->name('profile.password');
    });
});
