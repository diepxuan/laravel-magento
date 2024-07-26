<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-07-26 15:45:22
 */

namespace Diepxuan\Magento;

use Diepxuan\Magento\Builders\CategoryBuilder;
use Diepxuan\Magento\Builders\ProductBuilder;
use Diepxuan\Magento\Builders\StoreConfigsBuilder;
use Diepxuan\Magento\Builders\StoreViewsBuilder;
use Diepxuan\Magento\Builders\StoreWebsitesBuilder;
use Diepxuan\Magento\Http\Request;
use Diepxuan\Magento\Utils\Oauth1;

class Magento
{
    /**
     * List products.
     */
    public static function products(): ProductBuilder
    {
        return new ProductBuilder(self::initOAuthRequest());
    }

    /**
     * List categories.
     */
    public static function categories(): CategoryBuilder
    {
        return new CategoryBuilder(self::initOAuthRequest());
    }

    public static function store_websites(): StoreWebsitesBuilder
    {
        return new StoreWebsitesBuilder(self::initOAuthRequest());
    }

    public static function store_views(): StoreViewsBuilder
    {
        return new StoreViewsBuilder(self::initOAuthRequest());
    }

    public static function store_configs(): StoreConfigsBuilder
    {
        return new StoreConfigsBuilder(self::initOAuthRequest());
    }

    /**
     * Initial OAuth Request.
     *
     * @param mixed $token
     * @param mixed $options
     * @param mixed $headers
     */
    private static function initOAuthRequest($token = [], $options = [], $headers = []): Request
    {
        $base_uri = implode('/', [
            config('magento.base_url'),
            config('magento.base_path'),
            config('magento.store_code'),
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
