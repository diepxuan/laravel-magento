<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 20:59:05
 */

namespace Diepxuan\Magento\Providers;

use Illuminate\Http\Client\PendingRequest;

class BearerTokenProvider extends BaseProvider
{
    public function authenticate(PendingRequest $request, string $connection): PendingRequest
    {
        /** @var string $token */
        $token = config('magento.connections.' . $connection . '.access_token');

        return $request->withToken($token);
    }
}
