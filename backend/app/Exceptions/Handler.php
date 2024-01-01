<?php

namespace App\Exceptions;

use App\Traits\ResponseMessage;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Enums\ResponseMessageEnums;
use Illuminate\Http\RedirectResponse;
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
     * @param Request $request
     * @param \Exception $exception
     * @return Response
     */
    public function render($request,Throwable $e): Response|JsonResponse
    {
        if ($this->isProductionEnv()) {
            $message = $this->getMessage($e);
            $statusCode = $this->getStatusCode($e);

            return response()->json($this->getCustomErrorMessage($message), $statusCode);
        }

        return parent::render($request, $e);
    }


    /**
     * @return bool
     */
    protected function isProductionEnv(): bool
    {
        return config('app.env') === 'production';
    }

    /**
     * @param Throwable $e
     * @return string
     */
    protected function getMessage(Throwable $e): string
    {
        $message = $e->getMessage();

        return !empty($message) ? $message : ResponseMessageEnums::REQUEST_ERROR;
    }

    /**
     * @param Throwable $e
     * @return string
     */
    protected function getStatusCode(Throwable $e): string
    {
        return $this->isHttpException($e) ? $e->getCode() : Response::HTTP_EXPECTATION_FAILED;
    }
}
