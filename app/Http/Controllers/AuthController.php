<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Auth;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private readonly Auth\Factory $auth, private readonly ResponseFactory $response)
    {
    }

    public function register(RegisterRequest $request, Hasher $hasher): JsonResponse
    {
        $user = new User([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => $hasher->make($request->validated('password')),
        ]);
        $user->save();

        $token = $this->auth->guard()->login($user);

        return $this->response->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->safe(['email', 'password']);

        if (!$token = $this->auth->guard()->attempt($credentials)) {
            return $this->response->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return $this->response->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->auth->guard()->factory()->getTTL() * 60,
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return $this->response->json($this->auth->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->auth->guard()->logout();

        return $this->response->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken($this->auth->guard()->refresh());
    }
}
