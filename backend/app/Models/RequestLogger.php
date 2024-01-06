<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLogger extends Model
{
    protected $table = "request_logs";
    protected $guarded = [];
}
