<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;

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

Route::fallback(function(){
   echo('Not Found');
});

// Route::resource('student', studentController::class);
Route::prefix('cms/admin')->group(function(){
    Route::view('dashboard', 'cms.dashboard')->name('dashboard');
    Route::resource('cities', CityController::class);
    Route::resource('Profession', ProfessionController::class);
});
