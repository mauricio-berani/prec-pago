<?php

use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/transactions', [TransactionController::class, 'create']);
Route::get('/statistics', [StatisticsController::class, 'getLast']);
Route::delete('/transactions', [TransactionController::class, 'delete']);
