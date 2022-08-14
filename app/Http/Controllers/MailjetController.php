<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Mailjet\LaravelMailjet\Facades\Mailjet;
use \Mailjet\Resources;

class MailjetController extends Controller
{
    public function index()
    {
        $templates = Mailjet::get(Resources::$Template)->getData();
        $data = collect($templates)->map(function ($item) {
            return [
                "name" => $item["Name"],
                "id" => $item["ID"],
                "preview" => route("preview", [
                    "id" => $item["ID"],
                    "previewId" => $item["Previews"][0],
                ]),
            ];
        });
        return response()->json($data);
    }

    public function show($id)
    {
        try {
            $template = Mailjet::get(Resources::$TemplateDetailcontent, ["id" => $id])->getData();
            return response()->json(
               $template
            );
        } catch (Exception $e) {
            return response()->json("Không lấy được dữ liệu")->setStatusCode(500);
        }
    }

    public function preview($id, $previewId)
    {
        $client = new Client();
        $data = $client->get("https://api.mailjet.com/v3/REST/template/{$id}/displaypreview/{$previewId}", [
            'auth' => [
                env("MAILJET_APIKEY"),
                env("MAILJET_APISECRET"),
            ],
        ]);

        return response($data->getBody()->getContents())->header('Content-Type', 'image/jpeg');
    }
}
