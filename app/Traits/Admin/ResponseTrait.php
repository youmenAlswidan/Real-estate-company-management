<?php

namespace App\Traits\Admin;

trait ResponseTrait
{
    public function successResponse(string $message, string $route)
    {
        return redirect()->route($route)->with('success', $message);
    }

    public function errorResponse(string $message, string $route)
    {
        return redirect()->route($route)->with('error', $message);
    }
}
