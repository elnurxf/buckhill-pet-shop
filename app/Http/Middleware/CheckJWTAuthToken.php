<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Lcobucci\JWT\Validation\Validator;

class CheckJWTAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        $clientToken = $request->bearerToken();

        var_dump(123);

        //try {

            $parser = new Parser();
            $token = $parser->parse($clientToken);

            return var_dump($token);

            $tokenId = $token->getHeader('jti');

            $validator = new Validator();

            $result = $validator->validate(
                $token,
                new SignedWith(
                    new Signer\Rsa\Sha256(),
                    InMemory::file(storage_path('app/jwt-keys/jwtRS256.key')),
                    InMemory::plainText(config('app.key'))
                )
            );

            //var_dump($token->claims()->get('user_uuid'));
            var_dump($result, $token->claims()->all());

        //} catch (\Exception $exception) {

        //}

        //try {
        //    $validator->assert($token, new RelatedTo('1234567891')); // doesn't throw an exception
        //    $validator->assert($token, new RelatedTo('1234567890'));
        //} catch (RequiredConstraintsViolated $e) {
        //    // list of constraints violation exceptions:
        //    var_dump($e->violations());
        //}

        if ($role == 'admin') {
            //var_dump('admin');
        }

        return $next($request);
    }
}
