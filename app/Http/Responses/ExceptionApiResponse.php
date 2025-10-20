<?php

namespace App\Http\Responses;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionApiResponse extends BaseApiResponse
{
    protected string $responseType = 'false';
    protected ?string $message = null;
    protected array $errors = [];

    public function __construct(Throwable $exception)
    {
        [$code, $message, $errors] = $this->extractFromException($exception);

        $this->statusCode = $code;
        $this->message = $message;
        $this->errors = $errors;

        parent::__construct([], $code);
    }

    protected function makeResponseData(): array
    {
        $response = [
            'response' => $this->responseType,
            'message' => $this->message,
        ];

        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        }

        return $response;
    }

    private function extractFromException(Throwable $e): array
    {
        // дефолт
        $code = 500;
        $message = $e->getMessage() ?: 'Ошибка сервера.';
        $errors = [];

        switch (true) {
            case $e instanceof ValidationException:
                $code = 422;
                $message = 'Переданные данные не корректны.';
                $errors = $e->errors();
                break;

            case $e instanceof AuthenticationException:
                $code = 401;
                $message = 'Требуется аутентификация. Пожалуйста, предоставьте действительные учётные данные.';
                break;

            case $e instanceof AuthorizationException || $e instanceof AccessDeniedHttpException:
                $code = 403;
                $message = 'У вас нет разрешения на выполнение этого действия.';
                break;

            case $e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException:
                $code = 404;
                $message = $e instanceof ModelNotFoundException
                    ? 'Запрашиваемый ресурс не найден.'
                    : "Запрашиваемая страница не существует.";
                break;

            case $e instanceof MethodNotAllowedHttpException:
                $code = 405;
                $message = "Метод не доступен для данного эндпоинта.";
                break;

            case method_exists($e, 'getStatusCode'):
                $code = $e->getStatusCode();
                $message = $e->getMessage() ?: $message;
                break;

            case $e instanceof QueryException:
                $errorCode = $e->errorInfo[1] ?? null;

                switch ($errorCode) {
                    case 1451:
                        $code = 409;
                        $message = 'Невозможно удалить ресурс: он используется другими записями.';
                        break;

                    case 1062:
                        $code = 409;
                        $message = 'Запись с такими данными уже существует.';
                        break;

                    default:
                        $code = 500;
                        $message = 'Произошла ошибка базы данных. Попробуйте позже.';
                        break;
                }
                break;
        }

        return [$code, $message, $errors];
    }

}
