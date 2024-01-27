<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
{
    public function rules(): array
    {
        return [
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'password_confirm' => 'required|same:password'
        ];
    }
}
