<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;

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
        $tokenBuilder = new Builder(new JoseEncoder(), ChainedFormatter::default());
        $algorithm    = new Sha256();
        $signingKey   = InMemory::plainText(config('app.key'));
        $now          = new \DateTimeImmutable();

        $token = $tokenBuilder->issuedBy(parse_url(config('app.url'), PHP_URL_HOST))
            ->permittedFor(config('app.url'))
            ->identifiedBy('4f1g23a12aa')
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('user_uuid', $user->uuid)
            ->getToken($algorithm, $signingKey);

        event(new Login('api', $user, false));

        return new JsonResponse([
            'success' => true,
            'code'    => Response::HTTP_OK,
            'token'   => $token->toString(),
        ], Response::HTTP_OK);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
