<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'trainings';
    protected $hidden = ['user_id'];

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d F Y',
        'updated_at' => 'datetime:d F Y',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function days()
    {
        return $this->hasMany(TrainingDay::class);
    }
}
