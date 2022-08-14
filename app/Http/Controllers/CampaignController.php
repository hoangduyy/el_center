<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\MailConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = Campaign::when($request->has("search"), function ($q) use ($request) {
            return $q->where('name', 'ilike', "%" . $request->search . "%");
        })
            ->with("templates")
            ->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner' => 'required',
            'name' => 'required',
            'url' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $camp = new Campaign();
        $camp->name = $request->name;
        $camp->banner = $request->banner;
        $camp->url = $request->url;

        if (!$request->has("slug") || !isset($request->slug) || $request->slug == "" || $request->slug == null) {
            $camp->slug = Str::slug($request->name);
        }
        else {
            $camp->slug = "empty";
        }
        $camp->save();
        if ($request->has("templates")) {
            $templates = [];
            foreach ($request->templates as $item) {
                $template = new MailConfig();
                $template->number_invited = isset($item["number_invited"]) ? $item["number_invited"] : 0;
                $template->template_id = $item["template_id"];
                $template->subject = $item["subject"];
                $templates[] = $template;
            }
            $camp->templates()->saveMany($templates);
        }

        return response()->json([
            "message" => "Thêm mới thành công",
        ]);
    }

    public function show($id)
    {
        $camp = Campaign::with("templates")->where("id",$id)->first();
        if ($camp == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        return response()->json($camp);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner' => 'required',
            'name' => 'required',
            'url' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $camp = Campaign::with("templates")->where("id",$id)->first();

        if ($camp == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }

        $camp->name = $request->name;
        $camp->banner = $request->banner;
        $camp->url = $request->url;

        $camp->templates()->delete();

        if ($request->has("templates")) {
            $templates = [];
            foreach ($request->templates as $item) {
                $template = new MailConfig();
                $template->number_invited = isset($item["number_invited"]) ? $item["number_invited"] : 0;
                $template->template_id = $item["template_id"];
                $template->subject = $item["subject"];
                $templates[] = $template;
            }
            $camp->templates()->saveMany($templates);
        }

        if (!$request->has("slug") || !isset($request->slug) || $request->slug == "" || $request->slug == null) {
            $camp->slug = Str::slug($request->name);
        } else {
            $camp->slug = $request->slug;
        }
        $camp->save();
        return response()->json(["message" => "Cập nhật thành công"]);
    }

    public function destroy($id)
    {
        $camp = Campaign::find($id);
        if ($camp == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $camp->delete();
        return response()->json([
            "message" => "Xoá chiến dịch thành công",
        ]);
    }
}
