<?php

namespace App\Support\Facades;

use App\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);