<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 21:04:41
 */

namespace Diepxuan\Magento\Contracts;

use Illuminate\Http\Client\PendingRequest;

interface AuthenticatesRequest
{
    public function authenticate(PendingRequest $request, string $connection): PendingRequest;
}
