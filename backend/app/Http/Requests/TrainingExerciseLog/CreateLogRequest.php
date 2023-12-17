<?php

namespace App\Http\Requests\TrainingExerciseLog;

use Illuminate\Foundation\Http\FormRequest;

class CreateLogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sets' => 'sometimes',
            'sets.*.id' => 'required|numeric',
            'sets.*.weight' => 'required|numeric',
            'sets.*.reps' => 'required|numeric',
            'exercise_id' => 'required|exists:exercises,id',
        ];
    }
}
