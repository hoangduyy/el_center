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

class SendMailActive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $leadId;
    public $campaignId;

    public function __construct($leadId, $campaignId)
    {
        $this->leadId = $leadId;
        $this->campaignId = $campaignId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lead = Lead::find($this->leadId);

        Mail::to($lead->email)->send(new AutoEmail($lead, $this->campaignId,0));
    }
}
