<?php

namespace App\Traits\Property;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Return a standardized success JSON response.
     *
     * @param mixed $data The data to include in the response.
     * @param string $message A success message.
     * @param int $status HTTP status code (default 200).
     * @return JsonResponse
     */
    public function successResponse($data = [], string $message = '', $status = 200): JsonResponse
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'Property'    => $data,
        ], $status);
    }

    /**
     * Return a standardized error JSON response.
     *
     * @param string $message Error message.
     * @param int $status HTTP status code (default 422).
     * @return JsonResponse
     */
    public function errorResponse(string $message = 'Something went wrong', $status = 422): JsonResponse
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
        ], $status);
    }
}
