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

// Route::get('/', function (Repositories\IAreaRepository $ara, Repositories\IBrewerRepository $brw, Repositories\ISizeRepository $siz, Repositories\ITasteRepository $tst, Repositories\ISakeRepository $sak, Repositories\IPhotoRepository $pht) {
//     // $northan = $ara->find(['id', 1]);
//     // $items = $brw->find();
//     // $items = $siz->findAll();
//     // $items = $tst->findAll();
//     $brewer = $brw->findAll();
//     // $items = $brewer;
//     // $items = $sak->getProducts($brewer);
//     $items = $sak->find([
//         'designations' => [1, 2, 3]
//     ]);
//     // $items = $pht->getAllByBrewer($brewer);


//     return view('welcome', ['items' => $items]);
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
