<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $pageSize = $request->query('pageSize') ?? 100;

        $data = Room::with('branch')->when($request->has("search"), function ($q) use ($request) {
            $term = strtolower($request->search);
            return $q->whereRaw('lower(name) like (?) ', ["%{$term}%"])
                ->orWhereRaw('lower(slug) like (?) ', ["%{$term}%"])
                ->orWhereRaw('lower(description) like (?) ', ["%{$term}%"]);
        })
            ->when($request->has("start_date"), function ($q) use ($request) {
                return $q->where('created_at', '>=', $request->start_date);
            })
            ->when($request->has("end_date"), function ($q) use ($request) {
                return $q->where('created_at', '<=', $request->end_date);
            })
            ->orderBy('id', 'desc')
            ->skip(($page - 1) * $pageSize)
            ->take($pageSize)
            ->get();


        $total = Room::when($request->has("search"), function ($q) use ($request) {
            $term = strtolower($request->search);
            return $q->whereRaw('lower(name) like (?) ', ["%{$term}%"])
                ->orWhereRaw('lower(description) like (?) ', ["%{$term}%"]);
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

    public function roomSchedules(Request $request)
    {

        // query Filter
        
        $startHour = $request->startHour;
        $endHour = $request->endHour;
        $days = $request->days;
        
        $data = Room::with('branch')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            "data" => $data,
            'days' => $days,
            'startHour' => $startHour,
            'endHour' => $endHour,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $model = $request->all();

        if (!$request->has("slug") || !isset($request->slug) || $request->slug == "" || $request->slug == null) {
            $model['slug'] = Str::slug($request->name);
        }

        Room::create($model);
        return response()->json([
            "message" => "Thêm mới thành công",
        ]);
    }

    public function show($id)
    {
        $model = Room::with('branch')->find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        return response()->json($model);
    }

    public function update($id, Request $request)
    {
        $model = Room::find($id);
        $model->name = $request->name;
        $model->description = $request->description;
        $model->branch_id = $request->branch_id;
        $model->save();
        return response()->json(["message" => "Cập nhật thành công"]);
    }

    public function destroy($id)
    {
        $model = Room::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $model->delete();
        return response()->json([
            "message" => "Xoá chiến dịch thành công",
        ]);
    }
}
