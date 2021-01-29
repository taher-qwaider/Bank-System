<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\spatie\AdminPermissionController;
use App\Http\Controllers\spatie\AdminRoleController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CurrencyContoroller;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\DebitUserController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\DebtPaymentController;
use App\Http\Controllers\DebtUserController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\IncomeTypeController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\spatie\RoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\spatie\PermissionController;
use App\Http\Controllers\spatie\RolePermissiomController;
use App\Http\Controllers\spatie\UserPermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Models\User;

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
Route::prefix('cms/admin')->middleware('auth:admin')->group(function(){
    Route::resource('roles', RoleController::class);
    Route::resource('premissions', PermissionController::class);

    Route::get('logout', [AdminAuthController::class,'logout'])->name('logout');

    Route::get('edit-password', [AdminAuthController::class, 'edit_password'])->name('edit-password');
    Route::put('updata-password', [AdminAuthController::class, 'updata_password'])->name('updata-password');

    Route::resource('Admins.Permissions', AdminPermissionController::class);
    Route::resource('Role.Permissions', RolePermissiomController::class);

    Route::get('admins/{admin}/roles', [AdminRoleController::class, 'index'])->name('admin.role.index');
    Route::post('admins/{admin}/roles', [AdminRoleController::class, 'store']);

    Route::get('users/{user}/permissions', [UserPermissionController::class, 'index'])->name('user.permission.index');
    Route::post('users/{user}/permissions', [UserPermissionController::class, 'store']);

    Route::get('edit-profile', [AdminAuthController::class, 'edit_profile'])->name('edit-profile');
    Route::post('updata-profile', [AdminAuthController::class, 'updata_profile'])->name('updata-profile');
});

Route::prefix('cms/user')->middleware('auth:user,admin')->group(function(){
    Route::resource('wallets', WalletController::class);
    Route::resource('debts', DebtController::class);
    Route::resource('debts-user', DebtUserController::class);
    Route::resource('debt.payments', DebtPaymentController::class);
    Route::resource('users', UserController::class);
    Route::delete('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{user}/forcedelete', [UserController::class, 'forceDelete'])->name('users.forcedelete');
    Route::get('logout', [UserAuthController::class,'logout'])->name('user.logout');

    Route::get('edit-profile', [UserAuthController::class, 'edit_profile'])->name('user.edit-profile');
    Route::post('updata-profile', [UserAuthController::class, 'updata_profile'])->name('user.updata-profile');

    Route::get('edit-password', [AdminAuthController::class, 'edit_password'])->name('user.edit-password');
    Route::put('updata-password', [AdminAuthController::class, 'updata_password'])->name('user.updata-password');
});


Route::prefix('cms/admin')->middleware('auth:admin,user', 'verified')->group(function(){

    Route::get('dashboard', function(){
        $users_count = User::count();
        return response()->view('cms.dashboard', [
            'users_count' => $users_count
        ]);
    })->name('dashboard');
    Route::resource('cities', CityController::class);
    Route::resource('Profession', ProfessionController::class);
    Route::resource('admins', AdminController::class);
    Route::delete('admins/{admin}/restore', [AdminController::class, 'restore'])->name('admins.restore');
    Route::delete('admins/{admin}/forcedelete', [AdminController::class, 'forceDelete'])->name('admins.forcedelete');
    Route::resource('currency', CurrencyContoroller::class);
    Route::resource('income_type', IncomeTypeController::class);
    Route::resource('income_type.income', IncomeController::class);
    Route::resource('expense_type', ExpenseTypeController::class);

});

// Login in System
Route::prefix('cms/admin')->middleware('guest:admin')->group(function(){
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login.view');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login');
});
Route::prefix('cms/user')->middleware('guest:user')->group(function(){
    Route::get('login', [UserAuthController::class, 'showLogin'])->name('user.login.view');
    Route::post('login', [UserAuthController::class, 'login'])->name('user.login');
});

// Email Verification
Route::get('/email/verify', function(){
    // return view('auth.verify-email');
    return "Go and verify your email";
})->middleware('auth:admin')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('dashboard');
})->middleware(['auth:admin', 'signed'])->name('verification.verify');

