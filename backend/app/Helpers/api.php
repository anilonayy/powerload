<?php

use App\Http\Responses\ApiResponse;

if (!function_exists('apiResponse')) {
    /**
     * Create a new ApiResponse instance.
     *
     * @param mixed $status
     * @param int $code
     * @param array $data
     * @return ApiResponse
     */
    function apiResponse($status, $code, $data = [])
    {
        return new ApiResponse($status, $code, $data);
    }

    function successResponse($code,$message, $data = [])
    {
        return new ApiResponse(true, $code,$message, $data);
    }

    function failResponse($code,$message , $data = [])
    {
        return new ApiResponse(false, $code ,$message , $data);
    }
}
