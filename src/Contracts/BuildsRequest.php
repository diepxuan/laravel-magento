<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 21:05:14
 */

namespace Diepxuan\Magento\Contracts;

use Illuminate\Http\Client\PendingRequest;

interface BuildsRequest
{
    /** Build a basic pending request to Magento */
    public function build(string $connection): PendingRequest;
}
