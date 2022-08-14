<?php

namespace App\Http\Controllers;

use App\Models\TimeKeepingsComplain;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class TimeKeepingComplainController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $complain = TimeKeepingsComplain::when($request->has("start") && $request->has("end"), function ($query) use ($request) {
            $start = date("Y-m-d", strtotime($request->query("start")));
            $end = date("Y-m-d", strtotime($request->query("end")));
            $query->whereBetween("created_at", [$start, $end]);
        })
            ->when($user->role != "admin", function ($query) use ($user) {
                $query->where("id", $user->id);
            })
            ->get();
            return response()->json([
                "data" => $complain,
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "date" => "required",
            "complain"=>"required",
        ]);

        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        $data["date"] =Carbon::parse(date("d-m-Y", strtotime($request->date)))->format("Y-m-d");

       $complain= TimeKeepingsComplain::create($data);
        return response()->json($complain);
    }
    public function update(Request $request,TimeKeepingsComplain $time_keeping_complain)
    {
        $request->validate([
            "reply"=>"required",
        ]);
        $time_keeping_complain->reply = $request->reply;
        $time_keeping_complain->save();
        return response()->json($time_keeping_complain);
    }
}
