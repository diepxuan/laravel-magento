<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 21:00:24
 */

namespace Diepxuan\Magento\Enums;

use Diepxuan\Magento\Providers\BaseProvider;
use Diepxuan\Magento\Providers\BearerTokenProvider;
use Diepxuan\Magento\Providers\OAuthProvider;

enum AuthenticationMethod: string
{
    case Token = 'token';
    case OAuth = 'oauth';

    public function provider(): BaseProvider
    {
        $class = match ($this) {
            AuthenticationMethod::Token => BearerTokenProvider::class,
            AuthenticationMethod::OAuth => OAuthProvider::class,
        };

        // @var BaseProvider $instance
        return app($class);
    }
}
