<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'min:5'],
            'password_confirm' => ['required','same:password' ],
        ];

        $customMessages = [
            'name.required' => 'Ad Soyad alanı zorunludur.',
            'email.required' => 'E Posta alanı zorunludur.',
            'email.email' => 'Lütfen geçerli bir e-posta girin.',
            'email.max' => 'E Posta  255 karakteden kısa olmalıdır.',
            'email.unique' => 'Bu E Posta kullanılamaz.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 5 karakterden oluşmalıdır.',
            'password_confirm.required' => 'Şifre Onay alanı zorunludur.',
            'password_confirm.same' => 'Şifre Onay alanı Şifre ile aynı olmalıdır!.'
        ];

        $request->validate($rules, $customMessages);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
