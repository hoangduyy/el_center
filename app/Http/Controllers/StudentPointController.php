<?php

namespace App\Http\Controllers;

use App\Models\StudentPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StudentPointController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $pageSize = $request->query('pageSize') ?? 3;

        $data = StudentPoint::when($request->has("search"), function ($q) use ($request) {
            $term = strtolower($request->search);
            return $q->whereRaw('lower(note) like (?) ',["%{$term}%"]) 
                     ->orWhereRaw('lower(point) like (?) ', ["%{$term}%"]);
        })
        ->when($request->has("class_id"), function ($q) use ($request) {
            return $q->where('class_id', '=', $request->class_id);
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


        $total = StudentPoint::when($request->has("search"), function ($q) use ($request) {
            $term = strtolower($request->search);
            return $q->whereRaw('lower(note) like (?) ',["%{$term}%"]) 
                     ->orWhereRaw('lower(point) like (?) ', ["%{$term}%"]);
        })
        ->when($request->has("class_id"), function ($q) use ($request) {
            return $q->where('class_id', '=', $request->class_id);
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


    public function store(Request $request)
    {


        $model = $request->all(); 
        $model['teacher_id'] = Auth::user()->id ?? 1;
        $model['point'] = ($request->speak  + $request->read + $request->write + $request->listen ) / 4; 

        StudentPoint::create($model);
        return response()->json([
            "message" => "Thêm mới thành công",
        ]);
    }

    public function show($id)
    {
        $model = StudentPoint::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        return response()->json($model);
    }

    public function update($id, Request $request)
    {
        $model = StudentPoint::find($id);
        $model['point'] = ($request->speak  + $request->read + $request->write + $request->listen ) / 4; 
        $model->listen = $request->listen;
        $model->speak = $request->speak;
        $model->read = $request->read;
        $model->write = $request->write;
        $model->save();
        return response()->json(["message" => "Cập nhật thành công"]);
    }

    public function destroy($id)
    {
        $model = StudentPoint::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $model->delete();
        return response()->json([
            "message" => "Xoá danh mục thành công",
        ]);
    }
}
