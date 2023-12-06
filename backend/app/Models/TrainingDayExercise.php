<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingDayExercise extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['exercise'];


    public function exercise() {
        return $this->belongsTo(Exercise::class);
    }
}
