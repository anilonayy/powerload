<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class ApiResponse implements Responsable
{
    protected $code;
    protected $data;
    protected $message;

    public function __construct($code, $message, $data = [])
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function toSuccess()
    {
        return response()->json([
            'success' => true,
            'message' => $this->message,
            'data' => $this->data,
        ], $this->code);
    }

    public function toFail()
    {
        return response()->json([
            'success' => false,
            'message' => $this->message,
            'errors' => $this->data,
        ], $this->code);
    }

    public function toResponse($request)
    {
        return response()->json([
            'message' => $this->message,
        ]);
    }
}
