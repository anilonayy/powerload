<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class ApiResponse implements Responsable
{
    protected $status;
    protected $code;
    protected $data;
    protected $message;

    public function __construct($status, $code, $message, $data = [])
    {
        $this->status = $status;
        $this->code = $code;
        $this->data = $data;
        $this->message = $message;
    }

    public function toResponse($request)
    {
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
        ], $this->code);
    }
}
