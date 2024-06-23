<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class ForgotPasswordRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => __('validate.required', ['field' => __('fields.email')]),
            'email.email'    => __('validate.validate', ['field' => __('fields.email')]),
            'email.exists'   => __('validate.exists', ['field' => __('fields.email')]),
        ];
    }
}
