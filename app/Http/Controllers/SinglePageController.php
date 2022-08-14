<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\Request;

class SinglePageController extends Controller
{
    public function index(Request $request)
    {
        return view('home');
    }

    public function info($slug)
    {
        $camp = Campaign::where("slug", $slug)->first();
        if ($camp == null) {
            return response()->json([
                "message" => "Không tìm thấy dữ liệu",
                "code" => -1,
            ]);
        }

        return response()->json([
            "code"=>0,
            "data"=>$camp
        ]);

    }
}
