<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-07-25 21:20:56
 */

namespace Diepxuan\Magento\Builders;

use Diepxuan\Magento\Models\StoreViews;
use Illuminate\Support\Collection;

class StoreViewsBuilder extends Builder
{
    protected $entity = StoreViews::ENTITY;
    protected $model  = StoreViews::class;

    protected function parseResponse($response): Collection
    {
        $fetchedItems = collect($response);
        $items        = collect([]);

        foreach ($fetchedItems as $index => $item) {
            /** @var StoreViews $model */
            $model = new $this->model($this->request, $item);

            $items->push($model);
        }

        return $items;
    }
}
