<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ];
    }
}
