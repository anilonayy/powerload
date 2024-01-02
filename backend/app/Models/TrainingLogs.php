<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TrainingLogs extends AppModel
{
    use HasFactory;

    protected $hidden = ['updated_at','created_at','training_end_time'];
    protected $fillable = ['user_id', 'training_id', 'training_day_id', 'status','training_end_time', 'duration'];
    protected $casts = [
        'created_at' => 'datetime:m F Y H:i',
        'training_end_time' => 'datetime:m F Y H:i'
    ];

    public function trainingList (): hasMany
    {
        return $this->hasMany(TrainingExerciseListLogs::class, 'training_exercise_log_id', 'id');
    }

    public function trainingDay (): BelongsTo
    {
        return $this->belongsTo(TrainingDay::class);
    }

    public function training (): HasOne
    {
        return $this->hasOne(Training::class, 'id', 'training_id');
    }
}
