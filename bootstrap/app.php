<?php

use App\Exceptions\ApiExceptionHandler;
use App\Http\Responses\ExceptionApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        /**
         * Код для использования app/Exceptions/ApiExceptionHandler
         * при желании использования этого подхода - раскомментировать
         */
//        $exceptions->render(function (Throwable $exception, Request $request) {
//            if ($request->expectsJson()) {
//                $handler = new ApiExceptionHandler();
//                foreach (ApiExceptionHandler::$handlers as $class => $method) {
//                    if ($exception instanceof $class) {
//                        return $handler->$method($exception, $request);
//                    }
//                }
//            }
//            return null; // для web оставить стандартное
//        });


        /**
         * Код для использования с Responses - ExceptionApiResponse
         * удалить или закомментировать при использовании подхода выше
         */
        $exceptions->render(function (Throwable $exception, Request $request) {
            if ($request->expectsJson()) {
                return (new ExceptionApiResponse($exception));
            }
            return null; // для web оставить стандартное
        });

        $exceptions->dontFlash([
            'current_password',
            'password',
            'password_confirmation',
        ]);

    })
    ->create();
