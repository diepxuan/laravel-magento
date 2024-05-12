<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-12 23:48:21
 */

namespace Diepxuan\Magento;

use Diepxuan\Magento\Builders\ProductBuilder;
use Diepxuan\Magento\Utils\Oauth1;
use Diepxuan\Magento\Utils\Request;

class Magento
{
    /**
     * list products.
     */
    public static function products(): ProductBuilder
    {
        return new ProductBuilder($this->request);
    }

    /**
     * Initial OAuth Request.
     *
     * @param mixed $token
     * @param mixed $options
     * @param mixed $headers
     */
    private static function initOAuthRequest($token = [], $options = [], $headers = [])
    {
        $base_uri = implode('/', [
            config('magento.base_url'),
            config('magento.base_path'),
            config('magento.version'),
        ]) . '/';

        $token = array_replace([
            'consumer_key'    => config('magento.consumer_key'),
            'consumer_secret' => config('magento.consumer_secret'),
            'token'           => config('magento.token'),
            'token_secret'    => config('magento.token_secret'),

            'signature_method' => Oauth1::SIGNATURE_METHOD_HMACSHA256,
        ], $token);

        $options = array_replace([
            'base_uri' => $base_uri,
        ], $options);

        return new Request($token, $options, $headers);
    }
}
