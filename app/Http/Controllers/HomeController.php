<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(LesliesApiWrapper $api)
    {
        return view('home');
    }
}
