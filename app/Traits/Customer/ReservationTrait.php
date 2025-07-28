<?php

namespace App\Traits\Customer;
use Illuminate\Http\JsonResponse;

trait ReservationTrait{

    public function successResponse($data = [], string $message = '', int $status = 200): JsonResponse
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public function errorResponse(string $message = 'Something went wrong', int $status = 422): JsonResponse
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
        ], $status);
    }
}