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

Route::get('/', 'DiscountController@application')->name('home');

Route::get('/apply', function() {
    return redirect()->route('home');
});

Route::post('/apply', 'DiscountController@apply');


Route::group(['prefix' => 'invite'], function() {
    Route::get('show/{invite}','InviteController@show')->name('invite.show');
    Route::get('redeem/{invite}','InviteController@redeem')->name('invite.redeem');
});

Route::group(['prefix' => 'person'], function() {
    Route::get('create', 'PersonController@create')->name('person.create');
    Route::post('store', 'PersonController@store')->name('person.store');
    Route::post('attend', 'PersonController@attend')->name('person.attend');
    Route::get('{person}','PersonController@show')->name('person.show');
});

//Auth::routes();
