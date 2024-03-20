<?php

use App\Http\Controllers\CasesController;
use App\Http\Controllers\ClientController;
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

Route::get('/',[ClientController::class, 'index']);


Route::group(['prefix' => 'cases'], function () {
    Route::get('create',[CasesController::class, 'add']);
    Route::post('create', [CasesController::class, 'create'])->name('create');
});

Route::group(['prefix' => 'client'], function () {
    Route::get('/search',[ClientController::class, 'select'])->name('search-client');
    Route::get('info', [ClientController::class, 'find'])->name('client-info');
});

