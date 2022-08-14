<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqPageController extends Controller
{
    public function index(Request $request)
    {
        return view('faq');
    }
}
