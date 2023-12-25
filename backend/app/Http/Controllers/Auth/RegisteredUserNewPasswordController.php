<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ResponseMessage;
use App\Enums\ResponseMessageEnums;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Response;

class RegisteredUserNewPasswordController extends Controller
{
    use ResponseMessage;

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'currentPassword' => ['required'],
            'newPassword' => ['required'],
            'newPasswordConfirm' => ['required', 'same:newPassword'],
        ]);

        if (!Hash::check($request->currentPassword, Auth::user()->password)) {
            throw new Exception(ResponseMessageEnums::WRONG_CREDENTIAL, Response::HTTP_UNAUTHORIZED);
        }

        auth()->user()->update(['password' => Hash::make($request->newPassword)]);

        return response()->json($this->getSuccessMessage());
    }
}
