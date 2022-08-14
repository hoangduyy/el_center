<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClassRoomController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $pageSize = $request->query('pageSize') ?? 3;

        $data = ClassRoom::with("user", "course", "room")
            ->when($request->has("search"), function ($q) use ($request) {
                $term = strtolower($request->search);
                return $q->whereRaw('lower(title) like (?) ', ["%{$term}%"]);
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


        $total = ClassRoom::when($request->has("search"), function ($q) use ($request) {
            $term = strtolower($request->search);
            return $q->whereRaw('lower(title) like (?) ', ["%{$term}%"]);
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
            'qty' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $model = $request->all();

        $model['user_id'] = Auth::user()->id ?? 1;

        if ($request->has("utilities")) {
            $model['utilities'] = json_encode($request->utilities);
        }

        $model = ClassRoom::create($model);

        return response()->json([
            "message" => "Thêm mới thành công",
        ]);
    }

    public function show($id)
    {
        $model = ClassRoom::with("user", "course", "room","room.branch", "teacher", "schedule", "orders")
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
            'qty' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $model = ClassRoom::find($id);
        $model->title = $request->title;
        $model->thumbnail = $request->thumbnail;
        $model->note = $request->note;
        $model->status = $request->status;
        $model->room_id = $request->room_id;
        $model->start_date = $request->start_date;
        $model->end_date = $request->end_date;
        $model->course_id = $request->course_id;

        if ($request->has("utilities")) {
            $model['utilities'] = json_encode($request->utilities);
        }

        $model->save();
        return response()->json(["message" => "Cập nhật thành công"]);
    }

    public function destroy($id)
    {
        $model = ClassRoom::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $model->delete();
        return response()->json([
            "message" => "Xoá chiến dịch thành công",
        ]);
    }


    public function getStudentInfo($id, $classId, Request $request)
    {


        // class info 

        $class = ClassRoom::with("user", "course", "room","room.branch", "teacher", "schedule")
            ->find($classId);

        if ($class == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }

        // student info 

        $student = User::with('profile')->find($id);
   
        // order

        $order = Order::where('user_id',$id)
        ->where('class_id', $classId)->first();


        return response()->json([
            "class" => $class,
            "student" => $student,
            "order" => $order,
            
        ]);


        return $classId;
        $userId = Auth::user()->id ?? 9;

        $schedules = ClassRoom::with('schedule', 'schedule.details')->where('teacher_id', $userId)->get();

        return response()->json([
            "message" => "get schedule",
            "userId" => $userId,
            "schedules" => $schedules
        ]);
    }
}
