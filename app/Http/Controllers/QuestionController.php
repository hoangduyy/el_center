<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Profile;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page') ?? 1;
        $pageSize = $request->query('pageSize') ?? 3;

        $data = Question::query()
            ->skip(($page - 1) * $pageSize)
            ->take($pageSize)
            ->get();

        $total = Question::query()->count();

        return response()->json([
            "data" => $data,
            "total" => $total,
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $params['da'] = arrayGet(request()->all(), 'da', 'a');

        $question = Question::create([
            "question" => arrayGet($params, 'question'),
            "da_a" => arrayGet($params, 'da_a'),
            "da_b" => arrayGet($params, 'da_b'),
            "da_c" => arrayGet($params, 'da_c'),
            "da_d" => arrayGet($params, 'da_d'),
            "da" => arrayGet($params, 'da'),
        ]);

        return response()->json([
            "message" => "Thêm mới thành công",
        ]);
    }

    public function edit($id)
    {
        $model = Question::query()->where('id', $id)->first();
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        return response()->json($model);
    }

    public function update($id, Request $request)
    {
        $profile = Question::where('id', $id)->first();

        $profile->question = $request->question;
        $profile->da_a = $request->da_a;
        $profile->da_b = $request->da_b;
        $profile->da_c = $request->da_c;
        $profile->da_d = $request->da_d;
        $profile->da = $request->da;

        $profile->save();

        return response()->json(["message" => "Cập nhật thành công"]);
    }

    public function destroy($id)
    {
        $model = Question::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $model->delete();
        return response()->json([
            "message" => "Xoá thành công",
        ]);
    }
}
