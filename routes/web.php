<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPermissionController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\PermissionController;

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
Route::prefix('cms/admin')->middleware('auth:admin', 'verified')->group(function(){
    Route::view('dashboard', 'cms.dashboard')->name('dashboard');
    Route::resource('cities', CityController::class);
    Route::resource('Profession', ProfessionController::class);
    Route::resource('admins', AdminController::class);
    Route::get('logout', [AdminAuthController::class,'logout'])->name('logout');
    Route::get('edit-password', [AdminAuthController::class, 'edit_password'])->name('edit-password');
    Route::put('updata-password', [AdminAuthController::class, 'updata_password'])->name('updata-password');

    Route::resource('roles', RoleController::class);
    Route::resource('premissions', PermissionController::class);

    Route::resource('Admins.Permissions', AdminPermissionController::class);

    Route::get('edit-profile', [AdminAuthController::class, 'edit_profile'])->name('edit-profile');
    Route::put('updata-profile', [AdminAuthController::class, 'updata_profile'])->name('updata-profile');
});
Route::prefix('cms/admin')->middleware('guest:admin')->group(function(){
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login.view');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login');
});
Route::get('/email/verify', function(){
    // return view('auth.verify-email');
    return "Go and verify your email";
})->middleware('auth:admin')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('dashboard');
})->middleware(['auth:admin', 'signed'])->name('verification.verify');

