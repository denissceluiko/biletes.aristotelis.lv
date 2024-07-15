<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\PersonController;
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

Route::get('/', [DiscountController::class, 'application'])->name('home');

Route::get('/apply', function() {
    return redirect()->route('home');
});

Route::post('/apply', [DiscountController::class, 'apply'])->name('discount.apply');


Route::group(['prefix' => 'invite'], function() {
    Route::get('show/{invite}', [InviteController::class, 'show'])->name('invite.show');
    Route::get('redeem/{invite}',[InviteController::class, 'redeem'])->name('invite.redeem');
});

Route::group(['prefix' => 'person'], function() {
    Route::get('create', [PersonController::class, 'create'])->name('person.create');
    Route::post('store', [PersonController::class, 'store'])->name('person.store');
    Route::post('attend', [PersonController::class, 'attend'])->name('person.attend');
    Route::get('{person}',[PersonController::class, 'show'])->name('person.show');
});

//Auth::routes();
