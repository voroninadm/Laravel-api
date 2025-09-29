<?php

namespace App\Exceptions;

use App\Http\Responses\ExceptionApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionHandler
{
    /**
     * Map of exception classes to their handler methods
     */
    public static array $handlers = [
        AuthenticationException::class => 'handleAuthenticationException',
        AccessDeniedHttpException::class => 'handleAuthenticationException',
        AuthorizationException::class => 'handleAuthorizationException',
        ValidationException::class => 'handleValidationException',
        ModelNotFoundException::class => 'handleNotFoundException',
        NotFoundHttpException::class => 'handleNotFoundException',
        MethodNotAllowedHttpException::class => 'handleMethodNotAllowedException',
        HttpException::class => 'handleHttpException',
        QueryException::class => 'handleQueryException',
    ];

    /**
     * Handle authentication exceptions
     */
    public function handleAuthenticationException(AuthenticationException|AccessDeniedHttpException $e, Request $request): JsonResponse
    {
//        раскомментировать для логирования ->
//        $this->logException($e, 'Authentication failed');

        return response()->json([
            'message' => 'Требуется аутентификация. Пожалуйста, предоставьте действительные учётные данные.',
        ], 401);
    }

    /**
     * Handle authorization exceptions
     */
    public function handleAuthorizationException(AuthorizationException $e, Request $request): JsonResponse
    {
//        раскомментировать для логирования ->
//        $this->logException($e, 'Authorization failed');

        return response()->json([
            'message' => 'У вас нет разрешения на выполнение этого действия.',
        ], 403);
    }

    /**
     * Handle validation form
     */
    public function handleValidationException(ValidationException $e, Request $request)
    {
        $errors = [];

        foreach ($e->errors() as $field => $messages) {
            foreach ($messages as $message) {
                $errors[$field] = [
                    $message,
                ];
            }
        }
//        раскомментировать для логирования ->
//        $this->logException($e, 'Validation failed', ['errors' => $errors]);


        return response()->json([
            'message' => 'Переданные данные не корректны.',
            'errors' => $errors,
        ], 422);
    }

    /**
     * Handle not found exceptions
     */
    public function handleNotFoundException(ModelNotFoundException|NotFoundHttpException $e, Request $request): JsonResponse
    {
//        раскомментировать для логирования ->
//        $this->logException($e, 'Resource not found');

        $message = $e instanceof ModelNotFoundException
            ? 'Запрашиваемый ресурс не найден.'
            : "Запрашиваемая страница '{$request->getRequestUri()}' не существует.";

        return response()->json([
            'message' => $message,
        ], 404);
    }

    /**
     * Handle method not allowed exceptions
     */
    public function handleMethodNotAllowedException(MethodNotAllowedHttpException $e, Request $request): JsonResponse
    {
//        раскомментировать для логирования ->
//        $this->logException($e, 'Method not allowed');

        return response()->json([
            'message' => "Метод {$request->method()} не доступен для данного эндпоинта.",
        ], 405);
    }

    /**
     * Handle general HTTP exceptions
     */
    public function handleHttpException(HttpException $e, Request $request): JsonResponse
    {
//        раскомментировать для логирования ->
//        $this->logException($e, 'HTTP exception occurred');

        return response()->json([
            'message' => $e->getMessage() ?: 'Ошибка HTTP.',
        ], $e->getStatusCode());
    }

    /**
     * Handle database query exceptions
     */
    public function handleQueryException(QueryException $e, Request $request): JsonResponse
    {
//        раскомментировать для логирования ->
//        $this->logException($e, 'Database query failed', ['sql' => $e->getSql()]);

        // Handle specific database constraint violations
        $errorCode = $e->errorInfo[1] ?? null;

        switch ($errorCode) {
            case 1451: // Foreign key constraint violation
                return response()->json([
                    'message' => 'Cannot delete this resource because it is referenced by other records.',
                    'type' => $this->getExceptionType($e),
                ], 409);

            case 1062: // Duplicate entry
                return response()->json([
                    'message' => 'A record with this information already exists.',
                    'type' => $this->getExceptionType($e),
                ], 409);

            default:
                return response()->json([
                    'message' => 'A database error occurred. Please try again later.',
                    'type' => $this->getExceptionType($e),
                ], 500);
        }
    }

    /**
     * Extract a clean exception type name
     */
    private function getExceptionType(Throwable $e): string
    {
        $className = basename(str_replace('\\', '/', get_class($e)));
        return $className;
    }

    /**
     * Log exception with context
     */
    private function logException(Throwable $e, string $message, array $context = []): void
    {
        $logContext = array_merge([
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'ip' => request()->ip(),
        ], $context);

        Log::warning($message, $logContext);
    }
}
