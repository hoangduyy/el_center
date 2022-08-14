<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    //

    public function index()
    {
        $templates = Template::all();
        return response()->json($templates);
    }

    public function show($id)
    {
        $template = Template::find($id);
        if ($template == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        return response()->json($template);
    }

    public function destroy($id)
    {
        $camp = Template::with("configs")->find($id);
        if ($camp == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        if ($camp->configs != null && count($camp->configs)>0) {
            return response()->json(['error' => "Mẫu email đang được thiết lập cho chiến dịch"], 400);
        }
        $camp->delete();
        return response()->json([
            "message" => "Xoá mẫu email thành công",
        ]);
    }

    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'html' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên không được bỏ trống',
            'html.required' => 'HTML không được bỏ trống',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                $validator->errors(),
            ], 500);
        }

        $template = new Template($request->all());
        $template->save();
        return response()->json("Thêm mới thành công");

    }
    public function update($id, Request $request)
    {
        $rules = array(
            'name' => 'required',
            'html' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên không được bỏ trống',
            'html.required' => 'HTML không được bỏ trống',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                $validator->errors(),
            ], 500);
        }

        $template = Template::find($id);
        $template->name = $request->name;
        $template->mailjet_id = $request->mailjet_id;
        $template->html = $request->html;
        $template->save();

        return response()->json("Thêm mới thành công");

    }
}
