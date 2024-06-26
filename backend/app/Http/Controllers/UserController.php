<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UserServiceInterface $userService;

    /**
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param UpdateUserRequest $request
     *
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        return Api::ok($this->userService->update((object) $request->validated()));
    }

    /**
     * @param UpdatePasswordRequest $request
     *
     * @return JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $this->userService->updatePassword((object) $request->validated());

        return Api::noContent();
    }
}
