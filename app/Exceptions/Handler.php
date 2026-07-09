<?php

namespace App\Exceptions;

use Illuminate\Http\Cookie;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NullSessionHandler;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;
use Illuminate\Http\Request;

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


public function render($request, Throwable $e)
{
    if ($e instanceof HttpException) {
        return view('errors.404', ['error_message' => $e->getMessage()])->withCookie(cookie('XSRF-TOKEN', csrf_token()));
    }

    if ($e instanceof \Illuminate\Database\QueryException) {
        $error_message = $e->getMessage();
        return view('errors.404', get_defined_vars());
    }

    if ($e instanceof ModelNotFoundException) {
        return view('errors.404', ['error_message' => $e->getMessage()])->withCookie(cookie('XSRF-TOKEN', csrf_token()));
    }

    if ($e instanceof ValidationException) {
        return view('errors.404', ['error_message' => $e->getMessage()])->withCookie(cookie('XSRF-TOKEN', csrf_token()));
    }

    if ($e instanceof AuthenticationException) {
        return view('errors.404', ['error_message' => $e->getMessage()])->withCookie(cookie('XSRF-TOKEN', csrf_token()));
    }

    if ($e instanceof AuthorizationException) {
        return view('errors.404', ['error_message' => $e->getMessage()])->withCookie(cookie('XSRF-TOKEN', csrf_token()));
    }

    if ($e instanceof NotFoundHttpException) {
        return view('errors.404', ['error_message' => $e->getMessage()])->withCookie(cookie('XSRF-TOKEN', csrf_token()));
    }

    if ($e instanceof MethodNotAllowedHttpException) {
        return view('errors.404', ['error_message' => $e->getMessage()])->withCookie(cookie('XSRF-TOKEN', csrf_token()));
    }

    // try {
    // $user = User::find($id);
    // $userId = $user->user_id;
    // } catch (\Error $e) {
    //     return view('errors.404', ['error_message' => $e->getMessage()]);
    // }

    return parent::render($request, $e)->withCookie(cookie('XSRF-TOKEN', csrf_token()));
}





}
