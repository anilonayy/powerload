<?php

namespace App\Services\Auth;

use App\Repositories\User\UserRepositoryInterface;
use App\Services\Auth\AuthServiceInterface;
use Dotenv\Exception\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class AuthService implements AuthServiceInterface
{
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

        return [
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ]
        ];
    }

    /**
     * @param object $payload
     * @return array
     */
    public function register(object $payload): array
    {
        $user = $this->userRepository->create($payload);

        return [
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken
        ];
    }

    public function forgotPassword(object $payload): array
    {
        $rateLimiterKey = "forgot-password-{$payload->email}";

        if (RateLimiter::tooManyAttempts($rateLimiterKey, 3)) {
            throw new TooManyRequestsHttpException(5, 'Too many attempts');
        }

        RateLimiter::hit($rateLimiterKey);

        return [
            'status' => __(Password::sendResetLink((array)['email' => $payload->email]))
        ];
    }

    public function resetPassword(object $payload): array
    {
        $status = Password::reset(
            [
                'email' => $payload->email,
                'password' => $payload->password,
                'password_confirmation' => $payload->password_confirm,
                'token' => $payload->token
            ],
            function ($user) use ($payload) {
                $user->forceFill([
                    'password' => Hash::make($payload->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw new ValidationException(message: __($status), code: Response::HTTP_BAD_REQUEST);
        }

        return ['status' => __($status)];
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $token = auth()->user()->currentAccessToken();

        if ($token) {
            auth()->user()->tokens()->where('id', $token->id)->delete();
        }
    }
}
