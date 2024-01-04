<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends AppModel
{
    use HasFactory;
    use SoftDeletes;

    protected $hidden = ['user_id'];
    protected $fillable = ['user_id', 'name'];
    protected $casts = [
        'created_at' => 'datetime:d F Y',
        'updated_at' => 'datetime:d F Y',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function days(): HasMany
    {
        return $this->hasMany(TrainingDay::class);
    }

    public function training_logs(): HasMany
    {
        return $this->hasMany(TrainingLogs::class);
    }
}
