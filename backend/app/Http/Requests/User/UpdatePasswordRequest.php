<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UpdatePasswordRequest extends Request
{
    public function rules(): array
    {
        return [
            'currentPassword'    => 'required',
            'newPassword'        => 'required',
            'newPasswordConfirm' => 'required', 'same:newPassword',
        ];
    }
}
