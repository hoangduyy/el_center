<?php

namespace App\Jobs;

use App\Mail\AutoEmail;
use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class HandleInvited implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $leadId;
    public $campaignId;
    public $invited;

    public function __construct($leadId, $campaignId, $invited)
    {
        $this->leadId = $leadId;
        $this->campaignId = $campaignId;
        $this->invited = $invited;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lead = Lead::where("id", $this->leadId)->first();
        Mail::to($lead->email)->send(new AutoEmail($lead, $this->campaignId, $this->invited));
    }
}
