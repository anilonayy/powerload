<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Rule;

class LoginRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
            'device_type' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('validate.required', ['field' => __('fields.email')]),
            'email.validate' => __('validate.email.validate'),
            'password.required' => __('validate.required', ['field' => __('fields.password')]),
            'device_type.required' => __('validate.required', ['field' => __('fields.device_type')]),
        ];
    }
}
