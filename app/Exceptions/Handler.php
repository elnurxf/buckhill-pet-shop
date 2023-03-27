<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {

            if ($exception instanceof NotFoundHttpException) {
                return new JsonResponse([
                    'success' => false,
                    'code'    => Response::HTTP_NOT_FOUND,
                    'error'   => __('Endpoint not found'),
                    'trace' => config('app.debug') ? $exception->getTrace() : [],
                ], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof ModelNotFoundException) {
                return new JsonResponse([
                    'success' => false,
                    'code'    => Response::HTTP_NOT_FOUND,
                    'error'   => __('Record not found'),
                    'trace' => config('app.debug') ? $exception->getTrace() : [],
                ], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof AccessDeniedHttpException) {
                return new JsonResponse([
                    'success' => false,
                    'code'    => Response::HTTP_FORBIDDEN,
                    'error'   => __('You don`t have access to this route'),
                    'trace' => config('app.debug') ? $exception->getTrace() : [],
                ], Response::HTTP_FORBIDDEN);
            }

            if ($exception instanceof ValidationException) {
                return new JsonResponse([
                    'success' => false,
                    'code'    => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'errors'  => $exception->errors(),
                    'error'   => __('Validation exception'),
                    'trace' => config('app.debug') ? $exception->getTrace() : [],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($exception instanceof AuthenticationException) {
                return new JsonResponse([
                    'success' => false,
                    'code'    => Response::HTTP_UNAUTHORIZED,
                    'error'   => __('Unauthenticated'),
                    'trace' => config('app.debug') ? $exception->getTrace() : [],
                ], Response::HTTP_UNAUTHORIZED);
            }
        }

        return parent::render($request, $exception);
    }
}
