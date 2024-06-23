<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutExerciseLogs extends Model
{
    protected $fillable = ['workout_log_id', 'workout_exercise_list_log_id', 'weight', 'reps', 'started_at', 'exercise_id'];

    protected $casts = [
        'created_at' => 'datetime:m F Y H:i',
        'updated_at' => 'datetime:m F Y H:i',
    ];

    public function workout_exercise_list_log(): BelongsTo
    {
        return $this->belongsTo(WorkoutExerciseListLogs::class);
    }

    public function calculateDuration()
    {
        return Carbon::parse($this->workout_end_time)->shortAbsoluteDiffForHumans($this->created_at, 2);
    }
}
