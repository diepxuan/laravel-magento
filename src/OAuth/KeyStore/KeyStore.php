<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 20:55:23
 */

namespace Diepxuan\Catalog\OAuth\KeyStore;

abstract class KeyStore
{
    public static function instance(): self
    {
        /** @var class-string<KeyStore> $class */
        $class = config('magento.oauth.keystore');

        /** @var KeyStore $instance */
        return app($class);
    }

    abstract public function get(string $connection): array;

    abstract public function set(string $connection, array $data): void;

    public function merge(string $connection, array $data): void
    {
        $merged = array_merge($this->get($connection), $data);

        $this->set($connection, $merged);
    }
}
