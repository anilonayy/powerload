<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json($this->authService->login((object) $request->validated()));
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {

        return response()->json($this->authService->register((object) $request->validated()), Response::HTTP_CREATED);
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        return response()->json($this->authService->forgotPassword((object) $request->validated()));
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return response()->json($this->authService->resetPassword((object) $request->validated()));
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return response()->json($this->authService->logout(), Response::HTTP_NO_CONTENT);
    }
}
