<?php

use App\Controllers\HomeController;
use App\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);