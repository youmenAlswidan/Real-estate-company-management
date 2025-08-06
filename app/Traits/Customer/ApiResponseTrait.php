<?php

namespace App\Traits\Customer;

trait ApiResponseTrait
{
    
    /**
     * Return a standardized error JSON response.
     *
     * @param string $message Error message.
     * @param int $status HTTP status code (default 422).
     * @return JsonResponse
     */
    protected function successResponse($data = null, $message = '', $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Return a standardized error JSON response.
     *
     * @param string $message Error message.
     * @param int $status HTTP status code (default 422).
     * @return JsonResponse
     */
    protected function errorResponse($message = 'Something went wrong', $code = 500)
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], $code);
    }
}
