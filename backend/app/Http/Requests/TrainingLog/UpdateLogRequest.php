<?php

namespace App\Http\Requests\TrainingLog;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'training_day_id' => 'sometimes|exists:training_days,id',
            'training_id' => 'sometimes|exists:trainings,id',
            'isCompleted' => 'sometimes|boolean'
        ];
    }
}
