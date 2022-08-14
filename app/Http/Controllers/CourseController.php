<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $pageSize = $request->query('pageSize') ?? 3;

        $data = Course::with("user")->with("level","classes")
            ->when($request->has("search"), function ($q) use ($request) {
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
            ->orderBy('id', 'desc')
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'thumbnail' => 'required',
            'price' => 'required',
            'content' => 'required',
            'description' => 'required',
            'number_of_hours' => 'required',
            'start_date' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $model = $request->all();

        if (!$request->has("slug") || !isset($request->slug) || $request->slug == "" || $request->slug == null) {
            $model['slug'] = Str::slug($request->title);
        }

        $model['user_id'] = Auth::user()->id ?? 1;

        if ($request->has("utilities")) {
            $model['utilities'] = json_encode($request->utilities);
        }

        $model = Course::create($model);

        return response()->json([
            "message" => "Thêm mới thành công",
        ]);
    }

    public function show($id)
    {
        $model = Course::with("user")->with("level")
            ->find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        return response()->json($model);
    }

    public function update($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'thumbnail' => 'required',
            'content' => 'required',
            'price' => 'required',
            'description' => 'required',
            'number_of_hours' => 'required',
            'start_date' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }
        $model = Course::find($id);
        $model->title = $request->title;
        $model->thumbnail = $request->thumbnail;
        $model->slug = $request->slug;
        $model->description = $request->description;
        $model->content = $request->content;
        $model->price = $request->price;
        $model->status = $request->status;
        $model->lectures = $request->lectures;
        $model->start_date = $request->start_date;
        $model->number_of_hours = $request->number_of_hours;
        $model->utilities = $request->utilities;

        if (!$request->has("slug") || !isset($request->slug) || $request->slug == "" || $request->slug == null) {
            $model->slug = Str::slug($request->title);
        }

        if ($request->has("utilities")) {
            $model['utilities'] = json_encode($request->utilities);
        }

        $model->save();
        return response()->json(["message" => "Cập nhật thành công"]);
    }

    public function destroy($id)
    {
        $model = Course::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $model->delete();
        return response()->json([
            "message" => "Xoá chiến dịch thành công",
        ]);
    }
}
