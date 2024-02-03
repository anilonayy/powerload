<?php

namespace App\Services\Auth;

use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * @throws UnauthorizedHttpException
     */
    public function login(object $payload): array
    {
        $credentials = [
            'email' => $payload->email,
            'password' => $payload->password
        ];

        if(! auth()->attempt($credentials,true)) {
            throw new UnauthorizedHttpException('Unauthorized', __('auth.failed'));
        }

        $user = auth()->user();
        $token = $user->createToken($payload->device_type, ['user'])->plainTextToken;

        return [
            'user' => UserResource::make($user),
            'token' => $token
        ];
    }


    public function register(object $payload): array
    {
        $user = $this->userRepository->create($payload);
        $token = $user->createToken('token')->plainTextToken;

        return [
            'user' => UserResource::make($user),
            'token' => $token
        ];
    }


    /**
     * @param object $payload
     * @return array
     */
    public function forgotPassword(object $payload): array
    {
        try {
            $status = Password::sendResetLink((array)['email' => $payload->email]);
        }
        catch (\Exception $e) {
            var_dump($e);
        }


        return [
            'status' => __($status),
            'code' => $status,
        ];
    }


    /**
     * @param object $payload
     * @return array
     * @throws HttpClientException
     */
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
            throw new HttpClientException(message: __('auth.reset_password.error'), code: Response::HTTP_BAD_REQUEST);
        }

        return ['status' => __('auth.reset_password.success')];
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
