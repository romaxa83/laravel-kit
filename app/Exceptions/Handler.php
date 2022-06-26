<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Throwable;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // переопределяем сообщения об ошибках
        if ($request->ajax() || $request->wantsJson())
        {
            $message = $exception->getMessage();

            // переопределяем статус код для неавторизованого пользователя
            if($exception instanceof AuthenticationException){
                return ApiController::errorJsonMessage($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
            }

            // при ошибки валидации формируем массив ошибок
            if($exception instanceof  ValidationException){
//                $message = [];
//                foreach ($exception->errors() as $errors){
//                    foreach($errors as $mes){
//                        $message[] = $mes;
//                    }
//                }
                return ApiController::errorJsonMessage($exception->getMessage(), Response::HTTP_BAD_REQUEST);
            }

            return ApiController::errorJsonMessage($message);
        }

        return parent::render($request, $exception);
    }
}
