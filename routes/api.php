<?php

use App\Http\Controllers\Api\{
    InvestimentController
};

use Illuminate\Support\Facades\Route;

Route::get('/', [InvestimentController::class, 'index']);
Route::post('/investiment', [InvestimentController::class, 'store']);
Route::get('/investiment/{id}', [InvestimentController::class, 'show']);
