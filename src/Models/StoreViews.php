<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-07-25 21:19:12
 */

namespace Diepxuan\Magento\Models;

#[\AllowDynamicProperties]
class StoreViews extends Model
{
    public const ENTITY   = 'store/storeViews';
    protected $entity     = 'store/storeViews';
    protected $primaryKey = 'id';
}
