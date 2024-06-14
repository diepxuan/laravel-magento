<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-06-14 16:06:17
 */

namespace Diepxuan\Magento\Builders;

use Diepxuan\Magento\Models\Model;
use Diepxuan\Magento\Models\StoreWebsites;

class StoreWebsitesBuilder extends Builder
{
    protected $entity = StoreWebsites::ENTITY;
    protected $model  = StoreWebsites::class;

    protected function parseResponse($response)
    {
        $fetchedItems = collect($response);
        $items        = collect([]);

        foreach ($fetchedItems as $index => $item) {
            /** @var Model $model */
            $model = new $this->model($this->request, $item);

            $items->push($model);
        }

        return $items;
    }
}
