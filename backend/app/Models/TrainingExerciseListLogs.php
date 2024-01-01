<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingExerciseListLogs extends Model
{
    use HasFactory;

    protected $with  = ['exercise','exercise_logs'];
    protected $hidden = ['updated_at','created_at','training_exercise_log_id'];
    protected $fillable = ['exercise_id', 'training_exercise_log_id', 'is_passed'];

    public function exercise (): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function exercise_logs(): HasMany
    {
        return $this->hasMany(TrainingExerciseLogs::class, 'training_exercise_list_log_id', 'id');
    }
}
