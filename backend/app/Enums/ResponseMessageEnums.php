<?php

namespace App\Enums;

final class ResponseMessageEnums
{
    const REQUEST_ERROR = 'Request error.';
    const REQUEST_COMPLETED = 'Request completed successfully.';
    const NO_TOKEN = 'TOKEN not found';
    const INVALID_PAYLOAD = 'Invalid Payload!';
    const NO_CONTENT = 'No Content!';
    const UNAUTHORIZED = 'Unauthorized!';
    const OK = 'Ok';
    const BAD_REQUEST = 'Bad Request!';
    const FORBIDDEN = 'Forbidden!';
    const NOT_FOUND = 'Not Found!';
    const USER_NOT_FOUND = 'User Not Found!';
    const USER_ALREADY_EXISTS = 'User Already Exists!';
    const WRONG_CREDENTIAL = 'There is no user with this email or password!';
    const WRONG_PASSWORD = 'Güncel Şifre Yanlış!';
}
