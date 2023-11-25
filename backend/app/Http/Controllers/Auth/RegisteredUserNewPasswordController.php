<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserNewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'currentPassword' => ['required'],
            'newPassword' => ['required'],
            'newPasswordConfirm' => ['required', 'same:newPassword'],
        ]);

        if (!Hash::check($request->currentPassword, auth()->user()->password)) {
            return apiResponse('Güncel şifre yanlış!',400)->toFail();
        }

        auth()->user()->update(['password' => Hash::make($request->newPassword)]);

        return apiResponse('Şifre başarıyla güncellendi!',200)->toSuccess();
    }
}
