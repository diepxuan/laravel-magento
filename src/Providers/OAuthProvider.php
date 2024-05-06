<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 20:59:53
 */

namespace Diepxuan\Magento\Providers;

use Diepxuan\Magento\OAuth\HmacSha256Signature;
use Diepxuan\Magento\OAuth\KeyStore\KeyStore;
use Diepxuan\Magento\OAuth\MagentoServer;
use GuzzleHttp\Middleware;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use League\OAuth1\Client\Credentials\ClientCredentials;
use League\OAuth1\Client\Credentials\TokenCredentials;
use Psr\Http\Message\RequestInterface;

class OAuthProvider extends BaseProvider
{
    public function authenticate(PendingRequest $request, string $connection): PendingRequest
    {
        $keyStore = KeyStore::instance();

        $keys = $keyStore->get($connection);

        Validator::validate($keys, [
            'oauth_consumer_key'    => 'required|string',
            'oauth_consumer_secret' => 'required|string',
            'oauth_verifier'        => 'required|string',
            'access_token'          => 'required|string',
            'access_token_secret'   => 'required|string',
        ]);

        return $request->withMiddleware(
            Middleware::mapRequest(static function (RequestInterface $request) use ($keys) {
                $credentials = new ClientCredentials();
                $credentials->setIdentifier($keys['oauth_consumer_key']);
                $credentials->setSecret($keys['oauth_consumer_secret']);

                $server           = new MagentoServer($credentials, new HmacSha256Signature($credentials));
                $server->verifier = $keys['oauth_verifier'];

                $tokenCredentials = new TokenCredentials();
                $tokenCredentials->setIdentifier($keys['access_token']);
                $tokenCredentials->setSecret($keys['access_token_secret']);

                $query = $request->getUri()->getQuery();

                $data = Str::of($query)
                    ->explode('&')
                    ->filter(static fn (string $parameter): bool => '' !== $parameter)
                    ->mapWithKeys(static function (string $parameter): array {
                        $pair = explode('=', $parameter);

                        return 2 === \count($pair)
                            ? [$pair[0] => $pair[1]]
                            : [$pair[0] => ''];
                    })->toArray()
                ;

                $headers = $server->getHeaders(
                    $tokenCredentials,
                    $request->getMethod(),
                    (string) $request->getUri()->withFragment('')->withQuery(''),
                    $data
                );

                return $request->withHeader('Authorization', $headers['Authorization']);
            })
        );
    }
}
