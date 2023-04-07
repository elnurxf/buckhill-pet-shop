<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $exception)
    {
        //if ($request->expectsJson()) {

        if ($exception instanceof NotFoundHttpException) {
            return new JsonResponse([
                'success' => 0,
                'data'    => [],
                'code'    => Response::HTTP_NOT_FOUND,
                'error'   => __('Endpoint not found'),
                'errors'  => [],
                'trace'   => config('app.debug') ? $exception->getTrace() : [],
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof ModelNotFoundException) {
            return new JsonResponse([
                'success' => 0,
                'data'    => [],
                'code'    => Response::HTTP_NOT_FOUND,
                'error'   => __('Record not found'),
                'errors'  => [],
                'trace'   => config('app.debug') ? $exception->getTrace() : [],
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return new JsonResponse([
                'success' => 0,
                'data'    => [],
                'code'    => Response::HTTP_FORBIDDEN,
                'error'   => __('You don`t have access to this route'),
                'errors'  => [],
                'trace'   => config('app.debug') ? $exception->getTrace() : [],
            ], Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof ValidationException) {
            return new JsonResponse([
                'success' => 0,
                'code'    => Response::HTTP_UNPROCESSABLE_ENTITY,
                'error'   => __('Validation exception'),
                'errors'  => $exception->errors(),
                'trace'   => config('app.debug') ? $exception->getTrace() : [],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($exception instanceof AuthenticationException) {
            return new JsonResponse([
                'success' => 0,
                'data'    => [],
                'code'    => Response::HTTP_UNAUTHORIZED,
                'error'   => __('Unauthorized'),
                'errors'  => [],
                'trace'   => config('app.debug') ? $exception->getTrace() : [],
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof ThrottleRequestsException) {
            return new JsonResponse([
                'success' => 0,
                'data'    => [],
                'code'    => Response::HTTP_TOO_MANY_REQUESTS,
                'error'   => __('Too Many Requests'),
                'errors'  => [],
                'trace'   => config('app.debug') ? $exception->getTrace() : [],
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return new JsonResponse([
                'success' => 0,
                'data'    => [],
                'code'    => Response::HTTP_METHOD_NOT_ALLOWED,
                'error'   => __('Method Not Allowed'),
                'errors'  => [],
                'trace'   => config('app.debug') ? $exception->getTrace() : [],
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }
        //}

        return new JsonResponse([
            'success' => 0,
            'data'    => [],
            'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
            'error'   => $exception->getMessage(),
            'errors'  => [],
            'trace'   => config('app.debug') ? $exception->getTrace() : [],
        ], Response::HTTP_INTERNAL_SERVER_ERROR);

    }
}
