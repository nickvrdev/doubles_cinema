<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cinema;

class HomeController extends Controller
{

    /**
     * Show the welcome page / booking page.
     */
    public function index()
    {
        $cinemas = Cinema::all();
        return view('home')->with(compact('cinemas'));
    }

}
