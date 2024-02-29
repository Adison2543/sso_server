<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return redirect()->route('login');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/users', [App\Http\Controllers\HomeController::class, 'userTable'])->name('userTable');
Route::get('/data', [App\Http\Controllers\HomeController::class, 'dataTable'])->name('dataTable');
Route::get('/permissions', [App\Http\Controllers\HomeController::class, 'permTable'])->name('user.perm');
Route::post('/different-account', [App\Http\Controllers\HomeController::class, 'getDifferentAccount'])->name('different-account');
Route::post('/users/store', [App\Http\Controllers\HomeController::class, 'storeUser'])->name('user.store');
Route::post('/users/update', [App\Http\Controllers\HomeController::class, 'updateUser'])->name('user.update');
Route::post('/users/delete', [App\Http\Controllers\HomeController::class, 'deleteUser'])->name('user.delete');
Route::post('/data/add', [App\Http\Controllers\HomeController::class, 'addData'])->name('data.add');
Route::post('/data/update', [App\Http\Controllers\HomeController::class, 'updateData'])->name('data.update');
Route::post('/data/delete', [App\Http\Controllers\HomeController::class, 'deleteData'])->name('data.delete');
