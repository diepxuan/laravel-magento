<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-06-14 16:02:27
 */

namespace Diepxuan\Magento\Models;

#[\AllowDynamicProperties]
class StoreWebsites extends Model
{
    public const ENTITY   = 'store/websites';
    protected $entity     = 'store/websites';
    protected $primaryKey = 'id';
}
