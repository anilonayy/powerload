<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingLogs extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function exercises ()
    {
        return $this->hasMany(TrainingExerciseLogs::class, 'training_log_id', 'id');
    }
}
