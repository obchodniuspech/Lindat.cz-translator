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



Route::get('/','App\Http\Controllers\APIController@index')->name('Překladač');


Route::get('/dashboard', function () {
    //return view('dashboard');
    return redirect('/');
})->middleware(['auth'])->name('dashboard');

//Route::get('/api/translate/{from}/{to}/{text}', [Controllers\APIController::class, 'create'])->name('listings.create');

Route::get('/api/translate/{from}/{to}/{storing}/{text}/','App\Http\Controllers\APIController@translate')->name('Přelož');
Route::get('/api/saveFavourite/{from}/{to}/{text}','App\Http\Controllers\APIController@translateSaveFavourite')->name('Ulož oblíbené');
Route::get('/api/saveSettings/{idoagree}/','App\Http\Controllers\APIController@translateSaveSettings')->name('Ulož nastavení');
Route::get('/api/deleteFavourite/{from}/{to}/{text}','App\Http\Controllers\APIController@translateUnSaveFavourite')->name('Smaž oblíbené');


Route::get('/about','App\Http\Controllers\APIController@about')->name('About');



require __DIR__.'/auth.php';
