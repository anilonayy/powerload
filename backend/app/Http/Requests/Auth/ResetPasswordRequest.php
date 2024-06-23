<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
{
    public function rules(): array
    {
        return [
            'token'            => 'required|string',
            'email'            => 'required|email',
            'password'         => 'required|string',
            'password_confirm' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'token.required'            => __('validate.required', ['field' => __('fields.token')]),
            'email.required'            => __('validate.required', ['field' => __('fields.email')]),
            'email.email'               => __('validate.validate', ['field' => __('fields.email')]),
            'password.required'         => __('validate.required', ['field' => __('fields.password')]),
            'password_confirm.required' => __('validate.required', ['field' => __('fields.password_confirm')]),
        ];
    }
}
