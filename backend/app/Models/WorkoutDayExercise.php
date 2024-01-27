<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutDayExercise extends Model
{
    protected $fillable = ['workout_day_id', 'exercise_id', 'sets', 'reps'];

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
