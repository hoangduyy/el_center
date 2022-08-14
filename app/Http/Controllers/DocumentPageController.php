<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentPageController extends Controller
{
    public function index(Request $request)
    {
        return view('document');
    }
}
