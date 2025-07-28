<?php

namespace App\Traits\Admin;

trait PropertyTypeTrait 
{
    public function successResponse(string $message) {
        return [
        'status' => true,
        'message' => $message 
    ];
    }

    public function errorResponse(string $message) {
        return [
        'status' => false,
        'message' => $message 
    ];
    }
}