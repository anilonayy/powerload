<?php

namespace App\Http\Requests\WorkoutLog;

use Illuminate\Foundation\Http\FormRequest;

class ExerciseHistoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'exercise_id' => 'required|numeric|exists:exercises,id',
            'date_frequency'=> 'required|numeric:1,2,3'
        ];
    }
}
