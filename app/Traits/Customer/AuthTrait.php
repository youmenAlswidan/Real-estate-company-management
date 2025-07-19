<?php

namespace App\Traits\Customer;

trait AuthTrait
{
    public function successJWTResponse($data = null, $message = 'Success', $token = null , $status = 201)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
            'token'   => $token
        ], $status);
    }

    public function errorJWTResponse($message = 'Error', $status)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
        ], $status);
    }

    public function respondWithTokenAndUser($data, $status)
    {
        return response()->json($data, $status);
    }
}
