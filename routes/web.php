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

Route::get('/', function (Repositories\IAreaRepository $ara, Repositories\IBrewerRepository $repos, Repositories\ISizeRepository $siz, Repositories\ITasteRepository $tst) {
    // $northan = $ara->find(['id', 1]);
    // $items = $repos->find();
    // $items = $siz->findAll();
    $items = $tst->findAll();

    return view('welcome', ['items' => $items]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
