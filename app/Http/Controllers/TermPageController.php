<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermPageController extends Controller
{
    public function index(Request $request)
    {
        return view('term');
    }
}
