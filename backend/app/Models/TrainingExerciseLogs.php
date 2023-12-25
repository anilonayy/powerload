<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingExerciseLogs extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['exercise'];
    protected $hidden = ['updated_at'];

    protected $casts = [
        'created_at' => 'datetime:m F Y H:i',
        'updated_at' => 'datetime:m F Y H:i'
    ];

    public function exercise ()
    {
        return $this->belongsTo(Exercise::class);
    }
}
