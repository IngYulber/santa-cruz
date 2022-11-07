<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetallePagoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReunionController;
use App\Http\Controllers\SancionController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilsController;
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

Route::get('/', [LoginController::class, 'create'])->name('index');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function(){
    Route::group(['prefix' => 'panel'], function () {
        Route::get('/', [DashboardController::class, 'create'])->name('create');
    });

    Route::group(['prefix' => 'utils'], function () {
        Route::get('/kpis', [UtilsController::class, 'Kpis'])->name('kpis');
    });

    Route::group(['prefix' => 'colaboradores'], function () {
        Route::get('/', [ColaboradorController::class, 'create'])->name('create-cola');
        Route::get('/list', [ColaboradorController::class, 'index'])->name('list-cola');
        Route::post('/store', [ColaboradorController::class, 'store'])->name('store-cola');
        Route::post('/update', [ColaboradorController::class, 'update'])->name('update-cola');
        Route::post('/status', [ColaboradorController::class, 'status'])->name('status-col');
    });

    Route::group(['prefix' => 'cobranza'], function () {
        Route::get('/', [PagoController::class, 'create'])->name('create-cobr');
        Route::get('/list', [PagoController::class, 'index'])->name('list-cobr');
        Route::get('/{id}', [PagoController::class, 'show'])->name('detail-cobr');
        Route::get('/{id}/list', [PagoController::class, 'showDetail'])->name('show-detail-cobr');
        Route::post('/store', [PagoController::class, 'store'])->name('store-cobr');
        Route::post('/update/detail/{id}', [DetallePagoController::class, 'update'])->name('update-detail-cobr');
    });

    Route::group(['prefix' => 'reuniones'], function () {
        Route::get('/', [ReunionController::class, 'create'])->name('create-reun');
        Route::get('/list', [ReunionController::class, 'index'])->name('list-reun');
        Route::get('/{id}', [ReunionController::class, 'show'])->name('detail-reun');
        Route::get('/{id}/list', [ReunionController::class, 'showDetail'])->name('show-detail-reun');
        Route::post('/update', [ReunionController::class, 'update'])->name('update-reun');
        Route::post('/store', [ReunionController::class, 'store'])->name('store-reun');
        Route::post('/update/detail/{id}', [AsistenciaController::class, 'update'])->name('update-detail-reun');
    });

    Route::group(['prefix' => 'sanciones'], function () {
        Route::get('/', [SancionController::class, 'create'])->name('create-sanc');
        Route::get('/list', [SancionController::class, 'index'])->name('list-sanc');
        Route::post('/store', [SancionController::class, 'store'])->name('store-sanc');
        Route::post('/update', [SancionController::class, 'update'])->name('update-sanc');
    });

    Route::group(['prefix' => 'perfil'], function () {
        Route::get('/', [UserController::class, 'create'])->name('create-perf');
        Route::get('/info', [UserController::class, 'index'])->name('list-perf');
        Route::post('/store', [SancionController::class, 'store'])->name('store-perf');
        Route::post('/update', [SancionController::class, 'update'])->name('update-perf');
    });

    Route::group(['prefix' => 'reportes'], function () {
        Route::get('/', [UtilsController::class, 'reportesView'])->name('reportes');
    });
});
