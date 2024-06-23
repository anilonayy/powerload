<?php

namespace App\Http\Requests\Shared;

use Illuminate\Foundation\Http\FormRequest;

class AllWithFiltersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'sometimes|numeric|min:0',
            'take' => 'sometimes|numeric|min:0|max:100',
            'descBy' => 'sometimes|string|in:id',
            'paginate' => 'sometimes|boolean',
        ];
    }
}
