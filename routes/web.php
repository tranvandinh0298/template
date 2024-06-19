<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// search
Route::get('/search', [SearchController::class, 'index'])->name("search.index");
Route::post('/search', [SearchController::class, 'search'])->name("search.search");
Route::get("/auth/qr", [SearchController::class, 'searchViaQR'])->name("search.qr");

Route::middleware(['requireContractNo'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get("/guide/{merTrxId}", [TransactionController::class, 'index'])->name('index');

        Route::post("/process", [TransactionController::class, 'processMegapayData'])->name('process');
        Route::get("/megapay-callback", [TransactionController::class, 'mgpResult'])->name('callback');
    });
});

