<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $list = Contact::orderBy('id', 'desc')->paginate(getConst('BE_PER_PAGE'));
        return view('backend.contact.index', compact('list'));
    }
}
