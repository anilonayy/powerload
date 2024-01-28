<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLogger extends Model
{
    protected $table = "request_logs";
    public $timestamps = false;
    protected $fillable = [
        'path',
        'action',
        'method',
        'request_body',
        'status_code',
        'ip_address',
        'user_agent',
        'user_id',
        'duration',
        'created_at'
    ];
}
