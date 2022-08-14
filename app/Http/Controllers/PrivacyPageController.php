<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyPageController extends Controller
{
    public function index(Request $request)
    {
        return view('privacy');
    }
}
