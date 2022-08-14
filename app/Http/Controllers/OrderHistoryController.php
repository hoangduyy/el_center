<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderHistory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\OrderHistoryExport;

class OrderHistoryController
{
    public function index(Request $request)
    {
        $page = $request->query('page') ?? 1;
        $pageOrderHistory = $request->query('pageSize') ?? 25;
        $userId = $request->query('userId');
        $classId = $request->query('classId');

        $query = OrderHistory::query();

        $query =  $query->OrderBy('id', 'desc')
            ->with('creator', 'creator.profile');

        if ($userId != null) {
            $query = $query->where('OrderHistorys.user_id', $userId);
        }

        if ($classId != null) {
            $query = $query->where('OrderHistorys.class_id', $classId);
        }

        $data =  $query
            ->skip(($page - 1) * $pageOrderHistory)
            ->take($pageOrderHistory)
            ->get();

        $total =  $query
            ->count();

        return response()->json([
            "total" => $total,
            "data" => $data,
        ]);
    }

    public function show($id)
    {

        $model = OrderHistory::where('id', $id)
            ->first();

        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        return response()->json($model);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total' => 'required',
            'fullName' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $model = $request->all();
        $model['creator_id'] = Auth::user()->id ?? 1;
        $model = OrderHistory::create($model);


        return response()->json([
            "message" => "Thêm mới đơn đăng ký thành công",
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [

            'total' => 'required',
            'fullName' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $model =  OrderHistory::find($id);
        $model->note = $request->note;
        $model->fullName = $request->fullName;
        $model->total = $request->total;
        $model['creator_id'] = Auth::user()->id ?? 1;

        $model->save();
        return response()->json([
            "message" => "Cập nhật đơn đăng ký thành công",
        ]);


    }


    public function destroy($id)
    {
        $model = OrderHistory::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $model->delete();
        return response()->json([
            "message" => "Xoá đơn đăng ký thành công",
        ]);
    }
}
