<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DataController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\HobbyController;
use App\Http\Controllers\UserController;

Route::get('/', [DataController::class, 'index']);

Route::get('/newData', [DataController::class, 'reloadData']);


Route::get('/countries', [CountryController::class, 'index']);
Route::get('/hobbies', [HobbyController::class, 'index']);

Route::post('/users', [UserController::class, 'store']);
Route::post('/deleteItems', [UserController::class, 'delete']);

require __DIR__.'/auth.php';
