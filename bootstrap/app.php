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
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontFlash([
            'current_password',
            'password',
            'password_confirmation',
        ]);

        /**
         * Доп условие, что все роуты по api возвращают ответ только в Json-формате
         */
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }
            return $request->expectsJson();
        });

        /**
         * Код для использования app/Exceptions/ApiExceptionHandler
         * при желании использования этого подхода - раскомментировать
         * Изменить условие для отрисовки стандартной страницы, если запрос не по api - по желанию
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
        $exceptions->render(function (Throwable $exception) {
                return (new ExceptionApiResponse($exception));
        });
    })
    ->create();
