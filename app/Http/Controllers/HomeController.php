<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Redirect us to welcome page {Task Solution Page}
    public function index()
    {
        return view('welcome');
    }
}