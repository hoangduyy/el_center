<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public function index(Request $request)
    {
        return view('frontend.about');
    }
}
