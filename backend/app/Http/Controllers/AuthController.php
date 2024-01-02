<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use Illuminate\Http\JsonResponse;
use App\Services\Auth\AuthServiceInterface;
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
        return response()->json($this->authService->login($request->validated()));
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return response()->json($this->authService->register($request->validated()), Response::HTTP_CREATED);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return response()->json($this->authService->logout(), Response::HTTP_NO_CONTENT);
    }
}
