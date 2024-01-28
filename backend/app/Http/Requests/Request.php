<?php

namespace App\Http\Requests;

use App\Traits\ResponseMessage;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ResponseMessageEnums;
use App\Helpers\Api;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Request extends FormRequest
{
    use ResponseMessage;
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        throw new HttpResponseException(Api::unprocessableEntity($errors, ResponseMessageEnums::INVALID_PAYLOAD));
    }
}
