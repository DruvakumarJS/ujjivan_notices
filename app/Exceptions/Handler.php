<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Custom error pages for specific HTTP error codes
        
        if ($exception instanceof QueryException && strpos($exception->getMessage(), 'No connection could be made') !== false) {
            return response()->view('errors.database', [], 500);
        }

        if (strpos($exception->getMessage(), 'Unknown column') !== false) {
           
            // Handle the error when a column is not found
            return response()->view('errors.column-not-found', [], 500);
        }

        return parent::render($request, $exception);
    }
}
