<?php

namespace App\Exceptions;

use Helper\ResponseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        //
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Trả về Json nếu Validate bị lỗi khi gọi API
//        if ($request->expectsJson()) {
            if ($exception instanceof ValidationException) {
                $errors = $exception->errors();
                return ResponseService::responseJsonError(Response::HTTP_UNPROCESSABLE_ENTITY, data_get(array_values($errors), '0.0'), null, $errors);
            } else if ($exception instanceof ModelNotFoundException) {
                return ResponseService::responseJsonError(Response::HTTP_NOT_FOUND, $exception->getMessage(), trans('errors.page_not_found'));
            } else if ($exception instanceof UnauthorizedHttpException | $exception instanceof AuthenticationException) {
                return ResponseService::responseJsonError(Response::HTTP_UNAUTHORIZED, trans('errors.unauthenticated'));
            } else if ($exception instanceof TokenInvalidException) {
                return ResponseService::responseJsonError(Response::HTTP_UNAUTHORIZED, trans('errors.unauthenticated'), trans('errors.invalid_token'));
            } else if ($exception instanceof TokenExpiredException) {
                return ResponseService::responseJsonError(Response::HTTP_UNAUTHORIZED, trans('errors.unauthenticated'), trans('errors.expired_token'));
            } else if ($exception instanceof NotFoundHttpException) {
                return ResponseService::responseJsonError(Response::HTTP_NOT_FOUND, trans('errors.route_not_found'));
            } else if ($exception instanceof HttpException) {
                return ResponseService::responseJsonError($exception->getStatusCode(), trans('errors.access_denied'), $exception->getMessage());
            } else {
                return ResponseService::responseJsonError(Response::HTTP_INTERNAL_SERVER_ERROR, trans('errors.something_error'), $exception->getMessage(), $exception->getTraceAsString());
            }
//        }
    }

    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }
}
