<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $pageSize = $request->query('pageSize') ?? 3;

        $data = Order::with("creator")
            ->with("class", "class.course")
            ->with("customer")
            ->skip(($page - 1) * $pageSize)
            ->take($pageSize)
            ->get();


        $total = Course::when($request->has("search"), function ($q) use ($request) {
            $term = strtolower($request->search);
            return $q->whereRaw('lower(title) like (?) ', ["%{$term}%"])
                ->orWhereRaw('lower(slug) like (?) ', ["%{$term}%"])
                ->orWhereRaw('lower(description) like (?) ', ["%{$term}%"])
                ->orWhereRaw('lower(content) like (?) ', ["%{$term}%"]);
             })
            ->when($request->has("status"), function ($q) use ($request) {
                return $q->where('status', '=', $request->status);
            })
            ->when($request->has("user_id"), function ($q) use ($request) {
                return $q->where('user_id', '=', $request->user_id);
            })
            ->when($request->has("start_date"), function ($q) use ($request) {
                return $q->where('created_at', '>=', $request->start_date);
            })
            ->when($request->has("end_date"), function ($q) use ($request) {
                return $q->where('created_at', '<=', $request->end_date);
            })
            ->count();

        return response()->json([
            "total" => $total,
            "data" => $data,
        ]);
    }
}
