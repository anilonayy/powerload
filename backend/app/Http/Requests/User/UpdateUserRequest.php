<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use Auth;

class UpdateUserRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id
        ];
    }
}
