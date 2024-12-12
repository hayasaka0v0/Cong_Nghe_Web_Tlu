<?php

use App\Http\Controllers\MedicinesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
// returns the home page with all posts
Route::get('/', [MedicinesController::class .'index']);

