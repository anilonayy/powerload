<?php

namespace App\Services\User;

use App\Enums\ResponseMessageEnums;
use App\Traits\ResponseMessage;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    use ResponseMessage;
    public function update(object $payload): array
    {
        $user = auth()->user();

        $user->update((array)$payload);

        return $this->getSuccessMessage([
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    /**
     * @param object $payload
     * @return array
     */
    public function updatePassword(object $payload): array
    {
        if (!Hash::check($payload->currentPassword, Auth::user()->password)) {
            throw new HttpClientException(ResponseMessageEnums::WRONG_PASSWORD, Response::HTTP_BAD_REQUEST);
        }

        auth()->user()->update(['password' => Hash::make($payload->newPassword)]);

        return $this->getSuccessMessage();
    }
}
