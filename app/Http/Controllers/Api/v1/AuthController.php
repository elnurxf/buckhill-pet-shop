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

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'code'    => Response::HTTP_NOT_FOUND,
                'message' => __('User not found'),
            ], Response::HTTP_NOT_FOUND);
        }

        if (!Hash::check($data['password'], $user->password)) {
            return new JsonResponse([
                'success' => false,
                'code'    => Response::HTTP_BAD_REQUEST,
                'message' => __('The password not match'),
            ], Response::HTTP_BAD_REQUEST);
        }

        // Generate JWT Token
        $configuration = Configuration::forAsymmetricSigner(
            new Signer\Rsa\Sha256(),
            InMemory::file(storage_path('app/jwt-keys/jwtRS256.key')),
            InMemory::plainText(config('app.key'))
        );

        $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));

        $token = $tokenBuilder
            ->issuedBy(parse_url(config('app.url'), PHP_URL_HOST))
            ->permittedFor(config('app.url'))
            ->identifiedBy(hash_hmac('sha256', random_bytes(16), config('app.key')))
            ->issuedAt(CarbonImmutable::now())
            ->expiresAt(CarbonImmutable::now()->addHour())
            ->withClaim('user_uuid', $user->uuid)
            ->getToken($configuration->signer(), $configuration->signingKey());

        var_dump($token);

        // Store newly genrated token
        $jwt = JWTTokens::create([
            'user_id'      => $user->id,
            'unique_id'    => $token->signature()->toString(),
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
            'token'   => $jwt->unique_id,
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
