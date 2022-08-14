<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailConfig extends Model
{
    use HasFactory;
    protected $table="mail_config";
    public $timestamps = false;

    public function campaign()
    {
        return $this->belongsTo(Campaign::class,"campaign_id");
    }
    public function template()
    {
        return $this->belongsTo(Template::class,"template_id");
    }

}
