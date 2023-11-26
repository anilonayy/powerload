<?php

use App\Http\Responses\ApiResponse;

if (!function_exists('apiResponse')) {
    /**
     * Create a new ApiResponse instance.
     *
     * @param bool $success
     * @param int $code
     * @param array $data
     * @return ApiResponse
     */
    function apiResponse($code,$title,$message,$data = [])
    {
        return new ApiResponse($code,$title,$message,$data);
    }
}
