<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-14 17:38:22
 */

namespace Diepxuan\Magento\Models;

class Order extends Model
{
    protected $entity     = 'orders';
    protected $primaryKey = 'entity_id';
}
