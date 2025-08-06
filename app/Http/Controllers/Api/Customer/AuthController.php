<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\LoginRequest;
use App\Http\Requests\Customer\RegisterRequest;
use App\Services\Customer\AuthService;

/**
 * Handles customer authentication through the API.
 */
class AuthController extends Controller
{
    // Service responsible for authentication logic
    protected $authService;

    /**
     * Inject the AuthService into the controller.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle customer registration.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        // Delegate registration logic to the AuthService
        return $this->authService->register($request->validated());
    }

    /**
     * Handle customer login.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // Delegate login logic to the AuthService
        return $this->authService->login($request->validated());
    }

    /**
     * Log out the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // Delegate logout logic to the AuthService
        return $this->authService->logout();
    }
}
