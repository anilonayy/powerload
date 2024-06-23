<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutExerciseListLogs extends Model
{
    protected $hidden = ['updated_at', 'created_at', 'workout_exercise_log_id'];
    protected $fillable = ['exercise_id', 'workout_exercise_log_id', 'is_passed'];

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function workout_log(): BelongsTo
    {
        return $this->belongsTo(WorkoutLogs::class);
    }

    public function exercise_logs(): HasMany
    {
        return $this->hasMany(WorkoutExerciseLogs::class, 'workout_exercise_list_log_id', 'id');
    }
}
