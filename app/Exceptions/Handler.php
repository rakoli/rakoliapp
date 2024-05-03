<?php

namespace App\Exceptions;

use Flugg\Responder\Exceptions\ConvertsExceptions;
use Flugg\Responder\Exceptions\Http\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use ConvertsExceptions;

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

    public function render($request, Throwable $e)
    {
        // Check for "api" prefix or Accept header
        if ($request->is('api/*') || $request->wantsJson()) {

            $this->convertDefaultException($e);

            if ($e instanceof HttpException) {
                return $this->renderResponse($e);
            }

            return $this->prepareJsonResponse($request, $e);
        }

        return parent::render($request, $e);
    }
}
