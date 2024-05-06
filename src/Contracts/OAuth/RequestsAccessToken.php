<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 21:04:00
 */

namespace Diepxuan\Magento\Contracts\OAuth;

interface RequestsAccessToken
{
    public function request(string $connection, string $key): void;
}
