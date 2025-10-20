<?php

namespace App\Http\Responses;

use Symfony\Component\HttpFoundation\Response;

class FailApiResponse extends BaseApiResponse
{
    public int $statusCode = Response::HTTP_BAD_REQUEST;
    protected ?string $message;
    protected array $errors = [];

    public function __construct(?string $message = null, array $errors = [], int $code = Response::HTTP_BAD_REQUEST)
    {
        $this->message = $message;
        $this->errors = $errors;
        parent::__construct([], $code);
    }

    protected function makeResponseData(): array
    {
        $response = [
            'response' => 'false',
            'message' => $this->message,
        ];

        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        }

        return $response;
    }
}
