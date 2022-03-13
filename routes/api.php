<?php

use App\Http\Controllers\Api\{
    InvestimentController,
    WithdrawalController
};

use Illuminate\Support\Facades\Route;

Route::get('/', [InvestimentController::class, 'index']);
Route::post('/investiment', [InvestimentController::class, 'store']);
Route::get('/investiment/{id}', [InvestimentController::class, 'show']);
Route::post('/withdrawal/', [WithdrawalController::class, 'store']);
