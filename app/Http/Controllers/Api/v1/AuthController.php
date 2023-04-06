<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\JWTTokens;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Ecdsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Carbon\CarbonImmutable;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        // Try to authorize
        if (!$token = auth()->attempt($data)) {
            return new JsonResponse([
                'success' => false,
                'code'    => Response::HTTP_BAD_REQUEST,
                'message' => __('The password not match'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = auth()->user();

        // Store newly genrated token
        $jwt = JWTTokens::create([
            'user_id'      => $user->id,
            'unique_id'    => $token,
            'token_title'  => 'Token for user ' . $user->uuid,
            'restrictions' => [
                'admin' => !$user->is_admin,
                'user'  => true,
            ],
            'permissions'  => [
                'admin' => $user->is_admin,
                'user'  => true,
            ],
            'expires_at'   => now()->addHour(),
            'last_used_at' => now(),
        ]);

        // Broadcast login event
        event(new Login('api', $user, false));

        return new JsonResponse([
            'success' => true,
            'code'    => Response::HTTP_OK,
            'token'   => $token,
        ], Response::HTTP_OK);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        //return $request->bearerToken();

        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        event(new Logout('api', auth()->user(), false));

        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
