<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingDay extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'training_days';
    protected $fillable = ['name', 'training_id'];

    public function exercises(): HasMany
    {
        return $this->hasMany(TrainingDayExercise::class);
    }
}
