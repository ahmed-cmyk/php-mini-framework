<?php

namespace App\Controllers;

use App\Support\Http\Response;

class HomeController
{
    public function index(): Response
    {
        return response()->view('home', ["message" => "Hello, World!"], 200);
    }
}