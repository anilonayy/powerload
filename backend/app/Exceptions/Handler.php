<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
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
    public function render($request, $exception)
    {

        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        return apiResponse('An Error occured',500,[
            'message' => $exception->getMessage()
        ])->toFail();


        // return parent::render($request, $exception);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return apiResponse('Validation Failed',400,$errors)->toFail();
    }

}
