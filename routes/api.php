<?php

use App\Http\Controllers\Api\{
    InvestimentController
};

use Illuminate\Support\Facades\Route;


Route::get('/investments', [InvestimentController::class, 'index']);
Route::post('/investments', [InvestimentController::class, 'store']);

Route::get('/', function () {
    return response()->json([
        'success' => true
    ]);
});
