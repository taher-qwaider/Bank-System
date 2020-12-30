<?php

use App\Http\Controllers\api\UserAuthController;
use App\Models\Admin;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('wellcome', function () {
    return response()->json(['massege'=>'Well come']);
});
Route::prefix('auth/')->group(function(){
    Route::post('login', [UserAuthController::class, 'login']);
});
Route::get('relation', function () {
    // $data = Admin::find(1)->city()->where('name', 'like', '%p%')->get();

    // $data = Admin::orderBy('id', 'DESC')->get()->take(10);
    // $data = Admin::limit(10)->offset(10)->get();
    // $data = City::withCount('admins')->get();
    // $data = City::with(['admins'=>function($query){
    //     $query->where('first_name', 'like', '');
    // }])->first();
    // $data = City::with(['admins.profession'=>function($query){
    //     $query->where('active', true)->get();
    // }])->get();
    // $data = City::withCount('admins')->has('admins', '=', '2')->get();
    $data = City::whereHas('admins',  function($query){
        $query->where('gender', 'M');
    })->get();

    return response()->json([
        'massege'=>'success',
        'statue'=>true,
        'data'=>$data
    ]);
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
