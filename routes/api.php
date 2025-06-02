<?php

use App\Http\Controllers\Api\V1\OperationController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WalletController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1/'
], static function () {
    Route::post('/operations', [OperationController::class, 'index']);
    Route::get('/users', [UserController::class, 'index']);
    Route::group(['prefix' => 'wallet/'], static function () {
        Route::post('/add-balance', [WalletController::class, 'add']);
        Route::post('/sub-balance', [WalletController::class, 'sub']);
    });
});

