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

// Route::get('/', function () {
//     return view('guests.apartments.index');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route gruppo Admin
Route::prefix('admin')
  ->namespace('Admin')
  ->middleware('auth')
  ->name('admin.')
  ->group(function() {
    Route::resource('apartments','ApartmentController');

    //Route pagamento
    Route::get('payment/{apartment}', 'PaymentController@payment')->name('payment');

    //Route checkout
    Route::post('checkout/{apartment}', 'PaymentController@checkout')->name('checkout');

    //Route user apartments
    Route::get('user-apartments', 'ApartmentController@userApartments')->name('user-apartments');

    //Route statistiche
    Route::get('statistics/{apartment}', 'ApartmentController@statistics')->name('statistics');

    //Route send email admin
    Route::post('send-email/{apartment}', 'ApartmentController@sendEmail')->name('send-email');
    //Route received emails
    Route::get('received-emails', 'ApartmentController@receivedEmails')->name('received-emails');
  });

//Route apartments per tutti gli utenti
Route::get('/', 'ApartmentController@index')->name('apartments.index');
Route::get('/apartments/{apartment}', 'ApartmentController@show')->name('apartments.show');

//Route per cercare gli appartamenti
Route::get('search', 'ApartmentController@search')->name('search');

//Route send email guest
Route::post('send-email/{apartment}', 'ApartmentController@sendEmail')->name('send-email');
