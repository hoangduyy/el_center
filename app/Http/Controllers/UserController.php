<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'fullName' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $id = Auth::user()->id;

        $model = User::find($id);
        $model->name = $request->name;
        $model->email = $request->email;
        if($request->password){
            $model->password = Hash::make($request->password);
        }
        $model->save();

        $profile = Profile::where('user_id', $model->id)->first();
        $profile->name = $request->fullName;
        $profile->avatar = $request->avatar;
        $profile->address = $request->address;
        $profile->birthday = $request->birthday;
        $profile->gender = $request->gender;
        $profile->facebook = $request->facebook;
        $profile->save();

        return response()->json(["message" => "Cập nhật thành công"]);
    }
}