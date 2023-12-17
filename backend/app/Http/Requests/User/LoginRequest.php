<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use Illuminate\Auth\Events\Failed;

class LoginRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
