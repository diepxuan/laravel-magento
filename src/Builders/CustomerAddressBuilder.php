<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-14 17:40:09
 */

namespace Diepxuan\Magento\Builders;

use Diepxuan\Magento\Exceptions\MagentoMethodNotImplementedException;
use Diepxuan\Magento\Models\CustomerAddress;

class CustomerAddressBuilder extends Builder
{
    protected $entity = 'customers/addresses';
    protected $model  = CustomerAddress::class;

    public function get($filters = []): void
    {
        throw new MagentoMethodNotImplementedException('This method is not available on this resource');
    }

    public function create($data): void
    {
        throw new MagentoMethodNotImplementedException('This method is not available on this resource');
    }
}
