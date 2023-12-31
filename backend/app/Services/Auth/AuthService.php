<?php

namespace App\Services\Auth;

use App\Repositories\User\UserRepositoryInterface;
use App\Services\Auth\AuthServiceInterface;
use App\Traits\ResponseMessage;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Response;

class AuthService implements AuthServiceInterface
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
    public function login(object $payload): array
    {
        if(! auth()->attempt((array) $payload, true)) {
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
     * @param object $payload
     * @return array
     */
    public function register(object $payload): array
    {
        $user = $this->userRepository->create($payload);

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
