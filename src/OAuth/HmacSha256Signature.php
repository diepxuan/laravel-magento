<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 20:56:21
 */

namespace Diepxuan\Magento\OAuth;

use League\OAuth1\Client\Signature\HmacSha1Signature;

class HmacSha256Signature extends HmacSha1Signature
{
    public function method(): string
    {
        return 'HMAC-SHA256';
    }

    protected function hash($string): string
    {
        return hash_hmac('sha256', $string, $this->key(), true);
    }
}
