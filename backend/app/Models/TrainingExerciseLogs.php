<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingExerciseLogs extends AppModel
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['updated_at'];
    protected $fillable = ['training_exercise_list_log_id', 'weight', 'reps', 'started_at'];

    protected $casts = [
        'created_at' => 'datetime:m F Y H:i',
        'updated_at' => 'datetime:m F Y H:i'
    ];

    public function training_exercise_list_log(): BelongsTo
    {
        return $this->belongsTo(TrainingExerciseListLogs::class);
    }

    public function calculateDuration()
    {
        return Carbon::parse($this->training_end_time)->shortAbsoluteDiffForHumans($this->created_at, 2);
    }
}
