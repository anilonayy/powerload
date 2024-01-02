<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exercise extends AppModel
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(ExerciseCategory::class, 'exercise_categories_id');
    }
}
