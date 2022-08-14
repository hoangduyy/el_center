<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        return view("admin");
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Thông tin đăng nhập không chính xác',
            ], 401);
        }

        $user = User::with('profile')->where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function upload(Request $request)
    {
         
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {

            return response()->json([
                "code" => -1,
                'message' => $validator->errors(),
            ], 400);
        }

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            return response()->json([
                "code" => 0,
                "file" => "/storage/".$filePath,
            ]);
        }

    }
}