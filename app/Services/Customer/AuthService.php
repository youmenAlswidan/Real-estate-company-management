<?php

namespace App\Services\Customer;

use App\Http\Resources\Customer\AuthResource;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\Customer\AuthTrait;

class AuthService
{
    use AuthTrait;
     

    public function register(array $data)
    {
        try {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

           $user->assignRole('customer');



            $token = JWTAuth::fromUser($user);

            return $this->successResponse(new AuthResource($user, $token), 'Registered successfully', 201);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function login(array $credentials)
    {
        try {
            if (!$token = auth('api')->attempt($credentials)) {
                return $this->errorResponse('Invalid email or password', 401);
            }

            $user = auth('api')->user();

            return $this->successResponse(new AuthResource($user, $token), 'Login successful');
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function logout()
    {
        try {
            auth('api')->logout();
            return $this->successResponse([], 'Logged out successfully');
        } catch (\Throwable $e) {
            return $this->errorResponse('Logout failed: ' . $e->getMessage());
        }
    }

    public function myProfile()
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return $this->errorResponse('Unauthenticated', 401);
            }

            return $this->successResponse(new AuthResource($user, ''), 'My Profile');
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
