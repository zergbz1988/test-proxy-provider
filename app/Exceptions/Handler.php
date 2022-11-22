<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
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

    public function __construct(Container $container, private readonly ResponseFactory $response)
    {
        parent::__construct($container);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->renderable(function (ValidationException $e) {
            return $this->response->json([
                'code' => 'validation_error',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 400);
        });

        $this->renderable(function (InvalidArgumentException $e) {
            return $this->response->json([
                'code' => 'invalid_argument',
                'message' => $e->getMessage(),
            ], 400);
        });
    }

    protected function unauthenticated(
        $request,
        AuthenticationException $exception
    ): JsonResponse|Response|RedirectResponse {
        return $this->response->json(['message' => $exception->getMessage()], 401);
    }
}
