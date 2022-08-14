<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class SendLeadToNobita implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $requestData;
    public $extraData;
    public function __construct($requestData, $extraData)
    {
        $this->requestData = $requestData;
        $this->extraData = $extraData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json; charset=utf-8',
                'ApiKey' => env("NOBITA_KEY"),
            ],
        ]);

        if (isset($this->extraData)) {
            $data = array_merge($this->requestData, $this->extraData);
        } else {
            $data = $this->requestData;
        }

        $model_fields = array("phone", "name", "email");

        $model = Arr::where($data, function ($value, $key) use ($model_fields) {
            return in_array($key, $model_fields);
        });
        $metas = Arr::except($data, $model_fields);
        $model["fullName"] = $data["name"];
        $client->post('https://admin.ecrm.vn/public-api/v1/leads/createLead',
            ['json' => (object) array(
                "model" => $model,
                "queryString" => $metas,
            )]
        );
    }
}
