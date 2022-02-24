<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
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

Route::get('/', function () {
    //return view('welcome');
    return redirect('user-data-form');
});


Route::get('user-data-form', [PostController::class, 'index']);
Route::post('store-form', [PostController::class, 'store']);
Route::get('ajax-crud/{id}/edit',[PostController::class, 'getuser']);
Route::get('ajax-crud/{id}/delete',[PostController::class, 'deleteUser']);
Route::post('update-form', [PostController::class, 'updateUser']);