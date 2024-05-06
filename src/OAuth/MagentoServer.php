<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 20:57:35
 */

namespace Diepxuan\Magento\OAuth;

use League\OAuth1\Client\Credentials\CredentialsException;
use League\OAuth1\Client\Credentials\TemporaryCredentials;
use League\OAuth1\Client\Credentials\TokenCredentials;
use League\OAuth1\Client\Server\Server;
use League\OAuth1\Client\Server\User;

/** @codeCoverageIgnore */
class MagentoServer extends Server
{
    public string $verifier;

    public string $connection;

    public function urlTemporaryCredentials(): string
    {
        return config('magento.connections.' . $this->connection . '.base_url') . '/oauth/token/request';
    }

    public function urlAuthorization(): string
    {
        return '';
    }

    public function urlTokenCredentials(): string
    {
        return config('magento.connections.' . $this->connection . '.base_url') . '/oauth/token/access';
    }

    public function getTokenCredentials(TemporaryCredentials $temporaryCredentials, $temporaryIdentifier, $verifier)
    {
        $this->verifier = $verifier;

        return parent::getTokenCredentials($temporaryCredentials, $temporaryIdentifier, $verifier);
    }

    public function urlUserDetails(): string
    {
        return '';
    }

    public function userDetails($data, TokenCredentials $tokenCredentials): User
    {
        return new User();
    }

    public function userUid($data, TokenCredentials $tokenCredentials): int
    {
        return 0;
    }

    public function userEmail($data, TokenCredentials $tokenCredentials): void {}

    public function userScreenName($data, TokenCredentials $tokenCredentials): void {}

    protected function additionalProtocolParameters(): array
    {
        return [
            'oauth_verifier' => $this->verifier,
        ];
    }

    protected function createTemporaryCredentials($body): TemporaryCredentials
    {
        parse_str($body, $data);

        if (!$data || !\is_array($data)) {
            throw new CredentialsException('Unable to parse temporary credentials response.');
        }

        /** @var string $token */
        $token = $data['oauth_token'];

        /** @var string $secret */
        $secret = $data['oauth_token_secret'];

        $temporaryCredentials = new TemporaryCredentials();
        $temporaryCredentials->setIdentifier($token);
        $temporaryCredentials->setSecret($secret);

        return $temporaryCredentials;
    }
}
