<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingDay extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['exercises'];

    public function exercises()
    {
        return $this->hasMany(TrainingDayExercise::class);
    }

}
