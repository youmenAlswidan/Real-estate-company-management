<?php
namespace App\Services\Customer;

use App\Http\Resources\Customer\AuthResource;
use App\Models\User;
use App\Traits\Customer\AuthTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    use AuthTrait;

    public function register(array $data)
{
    try{
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $user->assignRole('customer');
            $token = JWTAuth::fromUser($user);


            return $this->respondWithTokenAndUser(
                new AuthResource($user, $token),
                201
            );

        }catch (\Exception $e) {
            return $this->errorJWTResponse($e->getMessage(), 422);
        }
}


    public function login(array $credentials)
    {
        try {
            if (! $token = auth('api')->attempt($credentials)) {
                throw new \Exception('Invalid email or password');
            }

            $user = auth('api')->user();

            return $this->respondWithTokenAndUser(
                new AuthResource($user, $token),
                201
            );

        } catch (\Exception $e) {
            return $this->errorJWTResponse($e->getMessage(), 422);
        }
    }

    public function logout()
    {
        try {
            auth('api')->logout();

            return $this->successJWTResponse(null, 'Successfully logged out');
        } catch (\Exception $e) {
            return $this->errorJWTResponse('Logout failed: ' . $e->getMessage(), 422);
        }
    }

    public function my_profile()
    {
        try {
        $user = auth('api')->user();

        if (!$user) {
            return $this->errorJWTResponse('Unauthenticated', 401);
        }

        return $this->respondWithTokenAndUser(
            new AuthResource($user, ''),
            201
        );
    } catch (\Exception $e) {
        return $this->errorJWTResponse($e->getMessage(), 422);
    }
    }
}
