<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingLogs extends Model
{
    use HasFactory;
    protected $table = 'training_logs';
    protected $with = ['exercises', 'training_day'];
    protected $guarded = [];

    public function exercises ()
    {
        return $this->hasMany(TrainingExerciseLogs::class, 'training_log_id', 'id');
    }

    public function training ()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }

    public function training_day()
    {
        return $this->hasOne(TrainingDay::class, 'id', 'training_day_id');
    }
}
