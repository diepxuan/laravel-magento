<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-06-17 21:44:55
 */

namespace Diepxuan\Magento;

use Diepxuan\Magento\Builders\CustomerAddressBuilder;
use Diepxuan\Magento\Builders\CustomerBuilder;
use Diepxuan\Magento\Builders\CustomerGroupBuilder;
use Diepxuan\Magento\Builders\OrderBuilder;
use Diepxuan\Magento\Builders\ProductBuilder;
use Diepxuan\Magento\Builders\StoreWebsitesBuilder;
use Diepxuan\Magento\Http\Request;
use Diepxuan\Magento\Utils\Oauth1;

class Magento2
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Rackbeat constructor.
     *
     * @param null  $token   API token
     * @param array $options Custom Guzzle options
     * @param array $headers Custom Guzzle headers
     */
    public function __construct($token = [], $options = [], $headers = [])
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

        $this->initOAuthRequest($token, $options, $headers);
    }

    public function orders(): OrderBuilder
    {
        return new OrderBuilder($this->request);
    }

    public function customers(): CustomerBuilder
    {
        return new CustomerBuilder($this->request);
    }

    public function customer_addresses(): CustomerAddressBuilder
    {
        return new CustomerAddressBuilder($this->request);
    }

    public function products(): ProductBuilder
    {
        return new ProductBuilder($this->request);
    }

    public function customer_groups(): CustomerGroupBuilder
    {
        return new CustomerGroupBuilder($this->request);
    }

    public function store_websites(): StoreWebsitesBuilder
    {
        return new StoreWebsitesBuilder($this->request);
    }

    /**
     * Initial OAuth Request.
     *
     * @param mixed $token
     * @param mixed $options
     * @param mixed $headers
     */
    private function initOAuthRequest($token = [], $options = [], $headers = []): void
    {
        $this->request = new Request($token, $options, $headers);
    }
}
