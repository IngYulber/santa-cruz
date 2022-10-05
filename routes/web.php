<?php

use App\Http\Controllers\PagoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReunionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', [LoginController::class, 'create'])->name('index');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function(){
    Route::group(['prefix' => 'panel'], function () {
        Route::get('/', [DashboardController::class, 'create'])->name('create');
    });

    Route::group(['prefix' => 'colaboradores'], function () {
        Route::get('/', [UserController::class, 'create'])->name('create');
        Route::get('/list', [UserController::class, 'index'])->name('list');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::post('/status', [UserController::class, 'status'])->name('status');
    });

    Route::group(['prefix' => 'cobranza'], function () {
        Route::get('/', [PagoController::class, 'create'])->name('create');
        Route::get('/list', [PagoController::class, 'index'])->name('list');
        Route::get('/{id}', [PagoController::class, 'show'])->name('detail');
        Route::get('/{id}/list', [PagoController::class, 'showDetail'])->name('show-detail');
        Route::post('/store', [PagoController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'reuniones'], function () {
        Route::get('/', [ReunionController::class, 'create'])->name('create');
        Route::get('/list', [ReunionController::class, 'index'])->name('list');
        Route::get('/{id}', [ReunionController::class, 'show'])->name('detail');
        Route::post('/store', [ReunionController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'sanciones'], function () {
        Route::get('/', [PagoController::class, 'create'])->name('create');
        Route::get('/list', [PagoController::class, 'index'])->name('list');
        Route::post('/store', [PagoController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'notificaciones'], function () {
        Route::get('/', [PagoController::class, 'create'])->name('create');
        Route::get('/list', [PagoController::class, 'index'])->name('list');
        Route::post('/store', [PagoController::class, 'store'])->name('store');
    });

});
