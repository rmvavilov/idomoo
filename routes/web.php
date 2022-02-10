<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\HomeController;
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


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

//region [VIDEOS]
Route::group([
    'middleware' => 'auth',
    'as' => 'video.',
    'prefix' => 'video'
], function () {
    Route::get('/', [VideoController::class, 'index',])->name('index');
    Route::get('/create', [VideoController::class, 'create',])->name('create');
    Route::post('/', [VideoController::class, 'store',])->name('store');
});
//endregion [VIDEOS]
