<?php

namespace App\Http\Controllers;

use App\Jobs\HandleInvited;
use App\Jobs\SendLeadToNobita;
use App\Jobs\SendMailActive;
use App\Models\Campaign;
use App\Models\Lead;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function store($id, Request $request)
    {
        $params = $request->all();

        try {
            $campaign = Campaign::find($id);
            if ($campaign == null) {
                dispatch(new SendLeadToNobita($params, null, null));
                return response()->json([
                    "code" => -1,
                    "message" => "Không tìm thấy chiến dịch",
                ]);
            }

            $extraData = array(
                "Khoá học" => $campaign->name,
            );
            $lead = new Lead();
            $parent = null;
            if ($request->has("ref")) {
                $parent = Lead::withCount("invited")
                    ->where("ref", $request->ref)
                    ->where("campaign_id", $id)
                    ->first();
                if ($parent != null) {
                    $lead->parent_id = $parent->id;
                    $extraData["Người mời"] = $parent->name . "/" . $parent->phone;
                }
            }

            $lead->name = $request->name;
            $lead->email = $request->email;
            $lead->phone = $request->phone;
            $lead->campaign_id = $id;
            $ref = Str::random(6);
            while (Lead::where("ref", $ref)
                ->where("campaign_id", $id)->exists()) {
                $ref = Str::random(6);
            }
            $lead->ref = $ref;

            $extraData["ref"] = $ref;

            try {
                $lead->save();
                dispatch(new SendMailActive($lead->id, $id));
                if ($parent != null) {
                    dispatch(new HandleInvited($lead->parent_id, $id, $parent->invited_count + 1));
                }
            } catch (Exception $err) {

            } finally {
                dispatch(new SendLeadToNobita($params, $extraData));
            }

            return response()->json([
                "code" => 0,
                "message" => "Đăng ký thành công",
            ]);

        } catch (Exception $e) {
            return response()->json([
                "code" => -1,
                "message" => "Dữ liệu không hợp lệ",
            ]);
        }
    }

    public function info($slug, Request $request)
    {
        $campaign = Campaign::where("slug", $slug)->first();

        if ($campaign == null) {
            return response()->json([
                "code" => -1,
                "message" => "Không tìm thấy chiến dịch",
            ]);
        }

        $phone = $request->phone;
        $user = Lead::with("invited:id,name,created_at,parent_id")
            ->where("campaign_id", $campaign->id)
            ->where("phone", $phone)
            ->select([
                "ref",
                "name",
                "id",
                "phone",
            ])
            ->first();

        return response()->json($user);

    }

    public function top($slug, Request $request)
    {
        $campaign = Campaign::where("slug", $slug)->first();
        if ($campaign == null) {
            return response()->json([
                "code" => -1,
                "message" => "Không tìm thấy chiến dịch",
            ]);
        }

        $user = Lead::has("invited", ">", 0)
            ->where("campaign_id", $campaign->id)
            ->select([
                "name",
            ])
            ->withCount("invited")
            ->orderBy('invited_count', 'desc')
            ->take(10)
            ->get();

        return response()->json($user);

    }

    public function index($id, Request $request)
    {
        $resp = Lead::where("campaign_id", $id)
        ->when($request->search,function($q){
            return $q->where("phone","ilike","%".request("search")."%")
            ->orWhere("email","ilike","%".request("search")."%")
            ->orWhere("name","ilike","%".request("search")."%");
        })
            ->withCount("invited")
            ->orderBy('invited_count', 'desc')
            ->paginate($request->pageSize);

        return response()->json([
            "total" => $resp->total(),
            "data" => $resp->items(),
        ]);
    }
}
