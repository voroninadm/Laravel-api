<?php

namespace App\Http\Responses;

class SuccessApiResponse extends BaseApiResponse
{

    /**
     * Формирование содержимого ответа.
     * @return array|null
     */
    protected function makeResponseData(): ?array
    {
        return [
            'status' => 'success',
            'data'   => $this->data ? $this->prepareData() : null,
        ];
    }
}
