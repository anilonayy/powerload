<?php

namespace App\Http\Requests\WorkoutExerciseLog;

use Illuminate\Foundation\Http\FormRequest;

class CreateLogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sets'              => 'sometimes',
            'sets.*.id'         => 'required|numeric',
            'sets.*.weight'     => 'required|numeric',
            'sets.*.reps'       => 'required|numeric',
            'exercise.id'       => 'required|exists:exercises,id',
            'exercise.isPassed' => 'required|boolean',
        ];
    }
}
