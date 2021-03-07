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

Route::prefix('calendar')->group(function() {
    Route::get('/', 'CalendarController@index');
    Route::post('/', 'CalendarController@store');
    Route::post('/{id}', 'CalendarController@update');
    Route::post('/{id}/delete', 'CalendarController@destroy');
    Route::get('/events', 'CalendarController@events');
});
