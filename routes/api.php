<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('accounts')->group(function () {
    Route::post('/', [AccountController::class, 'store']);
    Route::get('/{account}/balance', [AccountController::class, 'getBalance']);
    Route::get('/{account}/transactions', [AccountController::class, 'getTransactions']);
});
Route::post('/transactions', [TransactionController::class, 'store'])
    ->middleware('idempotency');
