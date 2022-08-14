<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogPostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $pageSize = $request->query('pageSize') ?? 3;

        $data = BlogPost::with("user")
            ->with("categories")
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


        $total = BlogPost::when($request->has("search"), function ($q) use ($request) {
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
            'content' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $model = $request->all();

        if (!$request->has("slug") || !isset($request->slug) || $request->slug == "" || $request->slug == null) {
            $model['slug'] = Str::slug($request->title);
        }

        $model['user_id'] = Auth::user()->id ?? 1;
        $model = BlogPost::create($model);

        if ($request->has("categories")) {
            foreach ($request->categories as $item) {
                $item['post_id'] = $model->id;
                BlogPostCategory::create($item);
            }
        }

        return response()->json([
            "message" => "Thêm mới thành công",
        ]);
    }

    public function show($id)
    {
        $model = BlogPost::with("user")
            ->with("categories")
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
            'description' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $model = BlogPost::with('categories')->find($id);
        $model->title = $request->title;
        $model->thumbnail = $request->thumbnail;
        $model->slug = $request->slug;
        $model->description = $request->description;
        $model->content = $request->content;
        $model->status = $request->status;

        if (!$request->has("slug") || !isset($request->slug) || $request->slug == "" || $request->slug == null) {
            $model->slug = Str::slug($request->title);
        }

        if($model->categories != null) {
            foreach ($model->categories as $item) { 
                BlogPostCategory::where("category_id",$item->pivot->category_id)
                                 ->where("post_id", $item->pivot->post_id)->delete();
            }
        }


        if ($request->has("categories")) {
            foreach ($request->categories as $item) {
                $item['post_id'] = $model->id;
                BlogPostCategory::create($item);
            }
        }


        $model->save();
        return response()->json(["message" => "Cập nhật thành công"]);
    }

    public function destroy($id)
    {
        $model = BlogPost::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $model->delete();
        return response()->json([
            "message" => "Xoá chiến dịch thành công",
        ]);
    }
}
