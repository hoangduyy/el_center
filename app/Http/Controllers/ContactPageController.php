<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;

class ContactPageController extends Controller
{
    public function index(Request $request)
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'fullName' => 'required',
                'message' => 'required',
            ],
            [
                'fullName.required' => 'Vui lòng nhập tên của bạn',
                'message.required' => 'Vui lòng nhập nội dung'
            ]
        );

        $data = $request->all();
        $data['status'] = false;

        try {
            Contact::create($data);
            return redirect("/contact")->with('success', 'Chúng tôi đã nhận được phản hồi từ bạn');
        } catch (Exception $e) {
            return redirect("/contact")->with('error', $e->getMessage());
        }

        return redirect("/contact")->with('error', 'ERROR');
    }
}
