<?php

namespace App\Http\Controllers;

use App\Http\Requests\Session\LoginRequest;
use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use Auth;
use Illuminate\Http\JsonResponse;

class SessionController extends Controller
{
    use ResponseMessage;

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(! Auth::attempt($attributes)) {
            throw new Exception(_('auth.failed'));
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        return response()->json($this->getSuccessMessage([
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ]
    ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy(): JsonResponse
    {
        $token = Auth::user()->currentAccessToken();

        if($token) {
            Auth::user()->tokens()->where('id', $token->id)->delete();
        }

        return response()->json($this->getSuccessMessage());
    }
}
