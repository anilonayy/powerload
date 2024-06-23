<?php

namespace App\Exceptions;

use App\Helpers\Api;
use App\Traits\ResponseMessage;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseMessage;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request   $request
     * @param Throwable $e
     *
     * @throws Throwable
     *
     * @return Response|JsonResponse
     */
    public function render($request, Throwable $e): Response|JsonResponse
    {
        if ($this->isProductionEnv($request)) {
            return Api::dynamic($this->getStatusCode($e, $request), null, $this->getMessage($e));
        }

        return parent::render($request, $e);
    }

    protected function isProductionEnv(Request $request): bool
    {
        return config('app.env') === 'production' || $request->header('X-Production') === 'true';
    }

    protected function getMessage(Throwable $e): string
    {
        $message = $e->getMessage();

        return !empty($message) ? $message : __('requests.error');
    }

    protected function getStatusCode(Throwable $e, Request $request): string
    {
        // TODO: This field will refactored.
        return $e->getCode() === 0 ? parent::render($request, $e)->getStatusCode() : $e->getCode();
    }
}
