<?php

namespace App\Mail;

use App\Models\Lead;
use App\Models\MailConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AutoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $campaignId;
    public $invited;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lead, $campaignId, $invited)
    {
        $this->lead = $lead;
        $this->campaignId = $campaignId;
        $this->invited = $invited;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $config = MailConfig::with(["template", "campaign"])
            ->where("campaign_id", $this->campaignId)
            ->where("number_invited", $this->invited)->first();

        if ($config == null || $config->template == null) {
            return;
        }

        $html = str_replace("{{name}}", $this->lead->name, $config->template->html);
        $html = str_replace("{{ name }}", $this->lead->name, $html);

        $html = str_replace("{{phone}}", $this->lead->phone, $html);
        $html = str_replace("{{ phone }}", $this->lead->phone, $html);

        $html = str_replace("{{email}}", $this->lead->email, $html);
        $html = str_replace("{{ email }}", $this->lead->email, $html);

        $html = str_replace("{{campaign}}",$config->campaign->name, $html);
        $html = str_replace("{{ campaign }}", $config->campaign->name, $html);

        $html = str_replace("{{invited}}", $this->invited, $html);
        $html = str_replace("{{ invited }}", $this->invited, $html);

        return $this->subject($config->subject)->html($html);
    }

}
