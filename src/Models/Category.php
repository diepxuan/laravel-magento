<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-14 17:35:55
 */

namespace Diepxuan\Magento\Models;

use Diepxuan\Magento\Models\Model;

#[\AllowDynamicProperties]
class Category extends Model
{
    protected $entity     = 'categories';
    protected $primaryKey = 'id';
}
