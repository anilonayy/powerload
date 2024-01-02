<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Auth\AuthServiceInterface;
use App\Traits\ResponseMessage;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;

class AuthService implements AuthServiceInterface
{
    use ResponseMessage;

    /**
     * @param array $payload
     * @return array
     */
    public function login(array $payload): array
    {
        if(! auth()->attempt($payload)) {
            throw new HttpClientException(message: __('auth.failed'), code: Response::HTTP_UNAUTHORIZED);
        }

        $user = auth()->user();
        $token = $user->createToken('token')->plainTextToken;

        return $this->getSuccessMessage([
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }

    /**
     * @param array $payload
     * @return array
     */
    public function register(array $payload): array
    {
        $user = User::create($payload);

        return $this->getSuccessMessage([
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken
        ]);
    }

    /**
     * @return array
     */
    public function logout(): array
    {
        $token = auth()->user()->currentAccessToken();

        if ($token) {
            auth()->user()->tokens()->where('id', $token->id)->delete();
        }

        return $this->getSuccessMessage();
    }
}
