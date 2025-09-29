<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseApiResponse implements Responsable
{
    public function __construct(
        protected mixed $data = [],
        public int      $statusCode = Response::HTTP_OK,
    )
    {
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->makeResponseData(), $this->statusCode);
    }

    /**
     * Преобразование возвращаемых данных к массиву.
     * @return array
     */
    protected function prepareData(): array|object
    {
        if ($this->data instanceof Arrayable) {
            return $this->data->toArray();
        }

        return $this->data;
    }

    /**
     * Формирование содержимого ответа.
     * @return array|null
     */
    abstract protected function makeResponseData(): ?array;
}
