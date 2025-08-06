<?php

namespace App\Traits\Customer;

trait ApiResponseTrait
{
    protected function successResponse($data = null, $message = '', $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message = 'Something went wrong', $code = 500)
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], $code);
    }
}
