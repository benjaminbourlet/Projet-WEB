<?php

namespace App\Http\Controllers;

class InfoController extends Controller
{
    public function showAbout()
    {
        return view('about');
    }
}

