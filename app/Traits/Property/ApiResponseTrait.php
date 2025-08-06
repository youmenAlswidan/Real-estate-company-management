<?php

namespace App\Traits\Property;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function successResponse($data = [], string $message = '', $status = 200): JsonResponse
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'Property'    => $data,
        ], $status);
    }

    public function errorResponse(string $message = 'Something went wrong', $status = 422): JsonResponse
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
        ], $status);
    }
}
