<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 20:50:46
 */

namespace Diepxuan\Magento\OAuth\KeyStore;

use Diepxuan\Magento\Models\OAuthKey;

class DatabaseKeyStore extends KeyStore
{
    public function get(string $connection): array
    {
        /** @var ?OAuthKey $key */
        $key = OAuthKey::query()->firstWhere('magento_connection', '=', $connection);

        return $key?->keys ?? [];
    }

    public function set(string $connection, array $data): void
    {
        OAuthKey::query()->updateOrCreate(
            [
                'magento_connection' => $connection,
            ],
            [
                'keys' => $data,
            ]
        );
    }
}
