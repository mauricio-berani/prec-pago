<?php

use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/transactions', [TransactionController::class, 'store']);
Route::get('/statistics', [StatisticsController::class, 'index']);
Route::delete('/transactions', [TransactionController::class, 'destroy']);
