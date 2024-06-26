<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WorkoutLogs extends Model
{
    protected $fillable = ['user_id', 'workout_id', 'workout_day_id', 'status', 'workout_end_time', 'duration'];

    public function workoutList(): hasMany
    {
        return $this->hasMany(WorkoutExerciseListLogs::class, 'workout_exercise_log_id', 'id');
    }

    public function workoutDay(): BelongsTo
    {
        return $this->belongsTo(WorkoutDay::class);
    }

    public function workout(): HasOne
    {
        return $this->hasOne(Workout::class, 'id', 'workout_id');
    }
}
