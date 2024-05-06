<?php

declare(strict_types=1);

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 *
 * © Tran Ngoc Duc <ductn@diepxuan.com>
 *   Tran Ngoc Duc <caothu91@gmail.com>
 */

namespace Diepxuan\Magento;

use Diepxuan\Magento\Builders\CustomerAddressBuilder;
use Diepxuan\Magento\Builders\CustomerBuilder;
use Diepxuan\Magento\Builders\CustomerGroupBuilder;
use Diepxuan\Magento\Builders\OrderBuilder;
use Diepxuan\Magento\Builders\ProductBuilder;
use Diepxuan\Magento\Utils\Request;

class Magento2
{
    /**
     * The Base URL of the Magento 2 store.
     *
     * @var string
     */
    public $baseUrl;

    /**
     * The Access Token defined from the Magento 2 application.
     *
     * @var null|string
     */
    public $token;

    /**
     * Determines if the API Version is included in the request.
     *
     * @var bool
     */
    public $versionIncluded = true;

    /**
     * The specified API version to use in the request.
     *
     * @var string
     */
    public $version;

    /**
     * The Magento 2 API base path.
     *
     * @var string
     */
    public $basePath;

    /**
     * The Magento 2 store code.
     *
     * @var string
     */
    public $storeCode;

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
    public function __construct($token, $options = [], $headers = [])
    {
        //     $this->baseUrl   = $baseUrl ?: config('magento.base_url');
        //     $this->token     = $token ?: config('magento.token');
        //     $this->version   = $version ?: config('magento.version') ?: 'V1';
        //     $this->basePath  = $basePath ?: config('magento.base_path') ?: 'rest';
        //     $this->storeCode = $storeCode ?: config('magento.store_code') ?: 'all';
        $this->initRequest($token, $options, $headers);
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

    /**
     * @param array $options
     * @param array $headers
     * @param mixed $token
     */
    private function initRequest($token, $options = [], $headers = []): void
    {
        $this->request = new Request($token, $options, $headers);
    }
}
