<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 16:08:56
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
     * initRequest.
     *
     * @param mixed $token
     * @param mixed $options
     * @param mixed $headers
     */
    private function initRequest($token, $options = [], $headers = []): void
    {
        $this->request = new Request($token, $options, $headers);
    }
}
