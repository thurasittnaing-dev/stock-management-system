<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['dashboard']]);
    }

    // Home
    public function home()
    {
        return view('home');
    }

    // Dashboard
    public function dashboard()
    {
        return view('dashboard');
    }
}