<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAPIController;

Route::post('create-user', [UserAPIController::class, 'create'])->name('create-user');
Route::get('user-list', [UserAPIController::class, 'index'])->name('user-list');
