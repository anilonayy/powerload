<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'name'        => 'required',
            'email'       => 'required|email|unique:users,email',
            'birthday'    => 'required|date',
            'password'    => ['required', Password::min(6)->letters()->numbers()->symbols()],
            'device_type' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => __('validate.required', ['field' => __('fields.name')]),
            'email.required'       => __('validate.required', ['field' => __('fields.email')]),
            'email.validate'       => __('validate.validate', ['field' => __('fields.email')]),
            'email.unique'         => __('validate.unique', ['field' => __('fields.email')]),
            'password.required'    => __('validate.required', ['field' => __('fields.password')]),
            'password.min'         => __('validate.min.string', ['field' => __('fields.password'), 'min' => 6]),
            'password.letters'     => __('validate.letters', ['field' => __('fields.password')]),
            'password.numbers'     => __('validate.numbers', ['field' => __('fields.password')]),
            'password.symbols'     => __('validate.symbols', ['field' => __('fields.password')]),
            'device_type.required' => __('validate.required', ['field' => __('fields.device_type')]),
        ];
    }
}
