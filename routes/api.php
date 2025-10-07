<?php

use App\Controllers\HomeController;
use App\Support\Facades\Route;

Route::get('/api/home', [HomeController::class, 'indexJson']);