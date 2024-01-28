<?php

namespace App\Services\User;

use App\Enums\ResponseMessageEnums;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ResponseMessage;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    use ResponseMessage;

    protected UserRepositoryInterface $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @param object $payload
     * @return array
     */
    public function update(object $payload): array
    {
        $user = $this->userRepository->update(auth()->user()->id, $payload);

        return [
            'name' => $user->name,
            'email' => $user->email
        ];
    }

    /**
     * @param object $payload
     * @return void
     */
    public function updatePassword(object $payload): void
    {
        $user = Auth::user();

        if (!Hash::check($payload->currentPassword, $user->password)) {
            throw new HttpClientException(ResponseMessageEnums::WRONG_PASSWORD, Response::HTTP_BAD_REQUEST);
        }

        $this->userRepository->update($user->id, (object) ['password' => Hash::make($payload->newPassword)]);
    }
}
