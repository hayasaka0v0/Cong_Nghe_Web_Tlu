<?php

use App\Http\Controllers\ClassesController;
use Illuminate\Support\Facades\Route;

Route::get('/', ClassesController::class .'@index')->name('classes.index');
