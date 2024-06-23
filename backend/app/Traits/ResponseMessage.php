<?php

namespace App\Traits;

use App\Enums\ResponseMessageEnums;

trait ResponseMessage
{
    /**
     * @param mixed $data
     *
     * @return array
     */
    public function getSuccessMessage(mixed $data = []): array
    {
        return ['success' => true, 'message' => ResponseMessageEnums::REQUEST_COMPLETED, 'data' => $data];
    }

    /**
     * @param mixed $data
     *
     * @return array
     */
    public function getFailMessage(mixed $data = []): array
    {
        return ['success' => false, 'message' => ResponseMessageEnums::REQUEST_ERROR, 'data' => $data];
    }

    /**
     * @param mixed $data
     *
     * @return array
     */
    public function getNotFoundMessage(mixed $data = []): array
    {
        return ['success' => false, 'message' => ResponseMessageEnums::NOT_FOUND, 'data' => $data];
    }

    /**
     * @param mixed $data
     *
     * @return array
     */
    public function getInvalidPayloadMessage(mixed $data = []): array
    {
        return ['success' => false, 'message' => ResponseMessageEnums::INVALID_PAYLOAD, 'data' => $data];
    }

    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public function getCustomSuccessMessage(string $message, mixed $data = []): array
    {
        return ['success' => true, 'message' => $message, 'data' => $data];
    }

    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public function getCustomErrorMessage(string $message, mixed $data = []): array
    {
        return ['success' => false, 'message' => $message, 'data' => $data];
    }
}
