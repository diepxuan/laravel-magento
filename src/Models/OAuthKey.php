<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 20:50:13
 */

namespace Diepxuan\Magento\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int     $id
 * @property string  $magento_connection
 * @property array   $keys
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class OAuthKey extends Model
{
    protected $table = 'magento_oauth_keys';

    protected $guarded = [];

    protected $casts = [
        'keys' => 'array',
    ];
}
