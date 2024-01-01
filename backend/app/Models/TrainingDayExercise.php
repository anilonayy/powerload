<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingDayExercise extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['exercise'];
    protected $fillable = ['training_day_id', 'exercise_id', 'sets', 'reps'];


    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
