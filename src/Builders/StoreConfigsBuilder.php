<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-07-26 15:38:19
 */

namespace Diepxuan\Magento\Builders;

use Diepxuan\Magento\Models\StoreConfigs;
use Illuminate\Support\Collection;

class StoreConfigsBuilder extends Builder
{
    protected $entity = StoreConfigs::ENTITY;
    protected $model  = StoreConfigs::class;

    protected function parseResponse($response): Collection
    {
        $fetchedItems = collect($response);
        $items        = collect([]);

        foreach ($fetchedItems as $index => $item) {
            /** @var StoreConfigs $model */
            $model = new $this->model($this->request, $item);

            $items->push($model);
        }

        return $items;
    }
}
