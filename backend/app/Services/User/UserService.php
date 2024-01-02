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
     * @param array $payload
     * @return array
     */
    public function update(array $payload): array
    {
        $user = $this->userRepository->update(auth()->user()->id, $payload);

        return $this->getSuccessMessage([
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    /**
     * @param array $payload
     * @return array
     */
    public function updatePassword(array $payload): array
    {
        if (!Hash::check($payload['currentPassword'], Auth::user()->password)) {
            throw new HttpClientException(ResponseMessageEnums::WRONG_PASSWORD, Response::HTTP_BAD_REQUEST);
        }

        $this->userRepository->update(Auth::user()->id, ['password' => Hash::make($payload['newPassword'])]);

        return $this->getSuccessMessage();
    }
}
