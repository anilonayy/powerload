<?php

namespace App\Http\Requests\Workout;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'train'                                   => 'required',
            'train.name'                              => 'required|string',
            'train.days'                              => 'required|array',
            'train.days.*.name'                       => 'required|string',
            'train.days.*.exercises'                  => 'required|array',
            'train.days.*.exercises.*.sets'           => 'required|integer',
            'train.days.*.exercises.*.reps'           => 'required|integer',
            'train.days.*.exercises.*.selected.value' => 'required|integer|exists:exercises,id',
        ];
    }
}
