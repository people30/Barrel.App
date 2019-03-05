<?php

use App\Repositories;

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

Route::get('/', 'RegionalityController')->name('RegionalityPage');
Route::get('/brewers/', 'BrewerController@index')->name('BrewersPage');
Route::get('/brewer/{slug}/', 'BrewerController@show')->name('BrewerDetailsPage');
Route::get('/sakes/', 'SakeController@index')->name('SakesPage');

// Auth::routes();