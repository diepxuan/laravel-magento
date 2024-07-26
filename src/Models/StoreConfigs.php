<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-07-26 15:28:07
 */

namespace Diepxuan\Magento\Models;

#[\AllowDynamicProperties]
class StoreConfigs extends Model
{
    public const ENTITY   = 'store/storeConfigs';
    protected $entity     = 'store/storeConfigs';
    protected $primaryKey = 'id';
}
