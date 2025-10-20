<?php

namespace App\Http\Responses;

use Illuminate\Pagination\AbstractPaginator;

class PaginatedApiResponse extends BaseApiResponse
{
    protected function makeResponseData(): array
    {
        if ($this->data instanceof AbstractPaginator) {
            $this->data = $this->data->toArray();
        }


        return array_merge([
            'response' => 'true'
        ], $this->prepareData());
    }
}
