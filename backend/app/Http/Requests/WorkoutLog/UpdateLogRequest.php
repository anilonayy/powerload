<?php

namespace App\Http\Requests\WorkoutLog;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'workout_day_id' => 'sometimes|exists:workout_days,id',
            'workout_id' => 'sometimes|exists:workouts,id',
            'isCompleted' => 'sometimes|boolean',
            'is_new' => 'sometimes|boolean',
        ];
    }
}
