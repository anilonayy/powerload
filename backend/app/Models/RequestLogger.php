<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestLogger extends AppModel
{
    protected $table = "request_logs";
    protected $guarded = [];
    use HasFactory;
}
