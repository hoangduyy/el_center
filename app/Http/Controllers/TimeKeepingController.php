<?php

namespace App\Http\Controllers;

use App\Models\TimeKeeping;
use App\Models\TimeKeepingsComplain;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class TimeKeepingController extends Controller
{
    //

    public function index(Request $request)
    {

        $user = Auth::user();

        $data = User::when($user->role != "admin", function ($query) use ($user) {
            $query->where("id", $user->id);
        })->when($request->has("user"), function ($query) use ($request) {
            $query->where("id", $request->query("user"));
        })->with("timeKeepings", function ($query) use ($request) {
            $query->when($request->has("start") && $request->has("end"), function ($query) use ($request) {
                $start = date("Y-m-d", strtotime($request->query("start")));
                $end = date("Y-m-d", strtotime($request->query("end")));
                $query->whereBetween("created_at", [$start, $end]);
            });
        })->get();

        return response()->json([
            "data" => $data,
        ]);
    }

    public function store(Request $request, TimeKeeping $timeKeeping)
    {
        $request->validate([
            "type" => "required|in:1,2",
        ]);
        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        if ($request->type == 1) {
            $data["compare_time"] = now()->diffInMinutes(now()->hour(8)->minute(0)->second(0), false);
        } else {
            $data["compare_time"] = now()->hour(17)->minute(0)->second(0)->diffInMinutes(now(), false);
        }
        $timeKeeping->create($data);

        return response()->json(["message" => "success"]);
    }

    public function update(Request $request)
    {
       

    }
}
