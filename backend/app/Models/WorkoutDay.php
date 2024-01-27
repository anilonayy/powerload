<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkoutDay extends Model
{
    use SoftDeletes;

    protected $table = 'workout_days';
    protected $fillable = ['name', 'workout_id'];

    public function exercises(): HasMany
    {
        return $this->hasMany(WorkoutDayExercise::class);
    }
}
