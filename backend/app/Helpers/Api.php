<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Api
{
    /**
     * Returns a JSON response for a successful request.
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public static function ok(mixed $data = null, string $message = 'OK'): JsonResponse
    {
        $code = Response::HTTP_OK;

        return response()->json([
            'success' => true,
            'status' => $code,
            'message' => $message,
            'data' => $data,
            'execution' => Api::getExecutionTime(),
        ], $code);
    }

    /**
     * Returns a JSON response for a resource created.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public static function created(mixed $data = null, string $message = 'CREATED') : JsonResponse
    {
        $code = Response::HTTP_CREATED;

        return response()->json([
            'success' => true,
            'status' => $code,
            'message' => $message,
            'data' => $data,
            'execution' => Api::getExecutionTime(),
        ], $code);
    }

    /**
     * Returns a JSON response for a resource accepted.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public static function accepted(mixed $data = null, string $message = 'ACCEPTED'): JsonResponse
    {
        $code = Response::HTTP_ACCEPTED;

        return response()->json([
            'success' => true,
            'status' => $code,
            'message' => $message,
            'data' => $data,
            'execution' => Api::getExecutionTime(),
        ], $code);
    }

    /**
     * Returns a JSON response with no content.
     *
     * @return JsonResponse
     */
    public static function noContent(): JsonResponse
    {
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Returns a JSON response for a bad request.
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function badRequest(mixed $errors = null, string $message = 'BAD REQUEST'): JsonResponse
    {
        $code = Response::HTTP_BAD_REQUEST;

        return response()->json([
            'success' => false,
            'status' => $code,
            'message' => $message,
            'errors' => $errors,
            'execution' => Api::getExecutionTime(),
        ], $code);
    }

    /**
     * Returns a JSON response for an unauthorized request.
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function unauthorized(mixed $errors = null, string $message = 'UNAUTHORIZED'): JsonResponse
    {
        $code = Response::HTTP_UNAUTHORIZED;

        return response()->json([
            'success' => false,
            'status' => $code,
            'message' => $message,
            'errors' => $errors,
            'execution' => Api::getExecutionTime(),
        ], $code);
    }

    /**
     * Returns a JSON response for a forbidden request.
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function forbidden(mixed $errors = null, string $message = 'FORBIDDEN'): JsonResponse
    {
        $code = Response::HTTP_FORBIDDEN;

        return response()->json([
            'success' => false,
            'status' => $code,
            'message' => $message,
            'errors' => $errors,
            'execution' => Api::getExecutionTime(),
        ], $code);
    }

    /**
     * Returns a JSON response for a not found request.
     *
     * @param mixed $errors
     * @return JsonResponse
     */
    public static function notFound(mixed $errors = null): JsonResponse
    {
        $code = Response::HTTP_NOT_FOUND;

        return response()->json([
            'success' => false,
            'status' => $code,
            'message' => 'NOT FOUND',
            'errors' => $errors,
            'execution' => Api::getExecutionTime(),
        ], $code);
    }

    /**
     *  Returns a JSON response for a method not allowed request.
     *
     * @param mixed $errors
     * @return JsonResponse
     */
    public static function methodNotAllowed(mixed $errors = null): JsonResponse
    {
        $code = Response::HTTP_METHOD_NOT_ALLOWED;

        return response()->json([
            'success' => false,
            'status' => $code,
            'message' => 'METHOD NOT ALLOWED',
            'errors' => $errors,
            'execution' => Api::getExecutionTime(),
        ], $code);
    }

    /**
     * Returns a JSON response for a request that is not acceptable.
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function unprocessableEntity(mixed $errors = null, string $message = 'UNPROCESSABLE ENTITY'): JsonResponse
    {
        $code = Response::HTTP_UNPROCESSABLE_ENTITY;

        return response()->json([
            'success' => false,
            'status' => $code,
            'message' => $message,
            'errors' => $errors,
            'execution' => Api::getExecutionTime(),
        ], $code);
    }

    /**
     * Returns a JSON response for error handling.
     *
     * @param integer $statusCode
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function dynamic(
        $statusCode = Response::HTTP_BAD_REQUEST,
        mixed $errors = null,
        string $message = 'ERROR'
        ): JsonResponse {
        return response()->json([
            'success' => false,
            'status' => $statusCode,
            'message' => $message,
            'errors' => $errors,
            'execution' => Api::getExecutionTime(),
        ], $statusCode);
    }

    /**
     * Returns the execution time of the request.
     *
     * @return string
     */
    public static function getExecutionTime (): string
    {
        return number_format(((microtime(true) - LARAVEL_START) * 1000), 0).' ms';
    }
}
