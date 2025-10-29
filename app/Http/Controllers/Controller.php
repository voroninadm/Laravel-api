<?php

namespace App\Http\Controllers;
use App\Http\Responses\PaginatedApiResponse;
use App\Http\Responses\SuccessApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(title="Api docs", version="0.9")
 */
abstract class Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function successResponse($data, ?int $code = Response::HTTP_OK): SuccessApiResponse
    {
        return new SuccessApiResponse($data, $code);
    }

    protected function paginatedResponse($data, ?int $code = Response::HTTP_OK): PaginatedApiResponse
    {
        return new PaginatedApiResponse($data, $code);
    }
}
