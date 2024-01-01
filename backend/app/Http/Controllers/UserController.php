<?php

namespace App\Http\Controllers;

use App\Enums\ResponseMessageEnums;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ResponseMessage;

    protected $authService;
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
        var_dump($this->authService);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register (RegisterRequest $request): JsonResponse
    {
        // $authService->register($request);

        $user = User::create($request->all());

        return response()->json($this->getSuccessMessage([
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken
        ]));
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $payload = $request->validated();

        if(! auth()->attempt($payload)) {
            return response()->json($this->getFailMessage([
                'message' => __('auth.failed')
            ]), Response::HTTP_UNAUTHORIZED);
        }


        $user = auth()->user();
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
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $token = auth()->user()->currentAccessToken();

        if($token) {
            auth()->user()->tokens()->where('id', $token->id)->delete();
        }

        return response()->json($this->getSuccessMessage());
    }

    /**
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = auth()->user();

        $user->update($request->all());

        return response()->json($this->getSuccessMessage([
            'name' => $user->name,
            'email' => $user->email
        ]));
    }

    /**
     * @param UpdatePasswordRequest $request
     * @return JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $payload = (object)$request->validated();

        if (!Hash::check($payload->currentPassword, Auth::user()->password)) {
            return response()->json($this->getCustomErrorMessage(
                ResponseMessageEnums::WRONG_PASSWORD,
            ), Response::HTTP_BAD_REQUEST);
        }

        auth()->user()->update(['password' => Hash::make($payload->newPassword)]);

        return response()->json($this->getSuccessMessage());
    }
}
