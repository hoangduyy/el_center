<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invited extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $lead;
    public function __construct($lead)
    {
        $this->lead = $lead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[Nobi Pro] Quà tặng workshop online tiktok ads 2021')
        ->view("Email.tiktok-invited", [
            "lead" => $this->lead,
        ]);
    }
}
