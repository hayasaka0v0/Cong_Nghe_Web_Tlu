<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComputerController;
Route::get('/', [ComputerController::class, 'index']);