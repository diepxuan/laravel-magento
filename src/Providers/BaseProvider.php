<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 20:58:36
 */

namespace Diepxuan\Magento\Providers;

use Illuminate\Http\Client\PendingRequest;

abstract class BaseProvider
{
    abstract public function authenticate(PendingRequest $request, string $connection): PendingRequest;
}
