<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingDay extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'training_days';
    protected $guarded = [];
    protected $with = ['exercises'];

    public function exercises()
    {
        return $this->hasMany(TrainingDayExercise::class);
    }

    public function training_logs()
    {
        return $this->belongsToMany(TrainingLogs::class, 'training_day_id', 'id');
    }

}
