<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $visible = ['id','name','category'];
    protected $with = ['category'];

    public function category()
    {
        return $this->belongsTo(ExerciseCategory::class,'exercise_categories_id');
    }
}
