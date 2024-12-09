<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExampleController;

Route::get('/example', [ExampleController::class, 'show']);
Route::get('/', [HomeController::class, "index"]);
Route::get("posts", [PostController::class, "index"]);