<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class ApiResponse implements Responsable
{
    protected $code;
    protected $data;
    protected $message;
    protected $title;

    public function __construct($code,$title, $message, $data = [])
    {
        $this->code = $code;
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
    }

    public function toSuccess()
    {
        return response()->json([
            'success' => true,
            'title' => $this->title ?? 'Başarılı',
            'message' => $this->message ?? 'İşlem Başarılı',
            'data' => $this->data,
        ], $this->code);
    }

    public function toFail()
    {
        return response()->json([
            'success' => false,
            'title' => $this->title ?? 'Başarısız!',
            'message' => $this->message ?? 'İşlem Başarısız',
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
