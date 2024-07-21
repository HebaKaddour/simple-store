<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResposeTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResposeTrait;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse('Unauthenticated', 401);
        }


    if($exception instanceof NotFoundHttpException){
        return $this->errorResponse('not found', 404);
    }

    if ($exception instanceof ModelNotFoundException) {
        $category = class_basename($exception->getModel());
        return response()->json(['message' => "$category not found"], 404);
    }

        if ($exception instanceof ValidationException) {
            $errors = $exception->validator->errors()->messages();

            $formattedErrors = [];
            foreach ($errors as $field => $messages) {
                $formattedErrors[$field] = array_values($messages)[0];
            }

            $response = [
                'errors:Validation failed.' => $formattedErrors,
            ];
            return $this->errorResponse($response, 422);
        }
        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }
        if ($exception instanceof \ErrorException && strpos($exception->getMessage(), 'Undefined variable') !== false) {
            $message = 'Undefined variable';
            return $this->errorResponse( $message , 500);

        }

            if ($exception instanceof \BadMethodCallException && strpos($exception->getMessage(), 'does not exist') !== false) {
                $message = 'Method does not exist';
                return $this->errorResponse($message , 500);

            }

            if ($exception instanceof AuthorizationException) {
                $message = 'You are not authorized to perform this action.';
                return $this->errorResponse( $message , 403);
            }
        return parent::render($request, $exception);
    }
}
