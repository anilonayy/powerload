<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            return apiResponse(400,'Hata!','Güncel şifre yanlış!')->toFail();
        }

        auth()->user()->update(['password' => Hash::make($request->newPassword)]);

        return apiResponse(200,'Başarılı!','Şifre başarıyla güncellendi!')->toSuccess();
    }
}
