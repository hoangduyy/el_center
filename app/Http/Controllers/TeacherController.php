<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class TeacherController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $pageSize = $request->query('pageSize') ?? 3;

        $data = User::with("profile")
            ->where('role','teacher')->when($request->has("search"), function ($q) use ($request) {
            $term = strtolower($request->search);
            return $q->whereRaw('lower(name) like (?) ', ["%{$term}%"])
                     ->orWhereRaw('lower(email) like (?) ', ["%{$term}%"])
                    ;
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


        $total = User::where('role','teacher')->when($request->has("search"), function ($q) use ($request) {
            $term = strtolower($request->search);
            return $q->whereRaw('lower(name) like (?) ', ["%{$term}%"])
                     ->orWhereRaw('lower(email) like (?) ', ["%{$term}%"])
                    ;
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
            'email' => 'required|unique:users',
            'fullName' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $customer = User::create([
            "name" => $request->name,
            "email" =>  $request->email,
            "role" =>  "teacher",
            'password' =>  $request->password ? Hash::make($request->password) : Hash::make($request->phone),
        ]);

        Profile::create([
            "user_id" => $customer->id,
            "name" => $request->fullName,
            "avatar" => $request->avatar,
            "address" => $request->address,
            "birthday" => $request->birthday,
            "gender" => $request->gender,
            "phone" => $request->phone,
            "facebook" => $request->facebook,
            "degree_id" => $request->degree_id,
            "certificate_id" => $request->certificate_id,
        ]);
        
        return response()->json([
            "message" => "Thêm mới thành công",
        ]);
    }

    public function show($id)
    {
        $model = User::with('profile')
        ->where('role','teacher')
        ->where('id',$id)
        ->first();
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        return response()->json($model);
    }

    public function update($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'fullName' => 'required',
        ]);
        $model = User::find($id);
        $model->name = $request->name;
        if($model->email != $request->email){
            $validator = Validator::make($request->all(), [
                'email' => 'unique:users'
            ]);
            
        }
        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }
        $model->email = $request->email;
        $model->save();

        $profile = Profile::where('user_id', $model->id)->first();
        $profile->name = $request->fullName;
        $profile->avatar = $request->avatar;
        $profile->address = $request->address;
        $profile->birthday = $request->birthday;
        $profile->gender = $request->gender;
        $profile->phone = $request->phone;
        $profile->facebook = $request->facebook;
        $profile->degree_id = $request->degree_id;
        $profile->certificate_id = $request->certificate_id;
        
        $profile->save();

        return response()->json(["message" => "Cập nhật thành công"]);
    }

    public function destroy($id)
    {
        $model = User::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $model->delete();
        return response()->json([
            "message" => "Xoá khách hàng thành công",
        ]);
    }

    public function getSchedule(Request $request)
    {
        $userId = Auth::user()->id ?? 9;
        
        $schedules = ClassRoom::with('schedule','schedule.details')->where('teacher_id', $userId)->get();
        

        return response()->json([
            "message" => "get schedule",
            "userId" => $userId,
            "schedules" => $schedules
        ]);
    }
}
