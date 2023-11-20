<?php

namespace App\Http\Requests\Session;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
{
    $errors = $validator->errors();

    $response = [
        'status' => false,
        'message' => 'Validation error',
        'errors' => $errors,
    ];

    throw new \Illuminate\Validation\ValidationException(
        response()->json($response, 422),
        $validator
    );
}

}
