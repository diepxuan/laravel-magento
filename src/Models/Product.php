<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-14 17:38:29
 */

namespace Diepxuan\Magento\Models;

#[\AllowDynamicProperties]
class Product extends Model
{
    protected $entity     = 'products';
    protected $primaryKey = 'sku';

    public function updateStockItem($data, $id = 1)
    {
        $data = [
            'stockItem' => $data,
        ];

        return $this->request->handleWithExceptions(function () use ($data, $id) {
            return $this->request->client->put("products/{$this->{urlencode($this->primaryKey)}}/stockItems/{$id}", [
                'json' => $data,
            ]);
        });
    }

    protected function setCustomAttributesAttribute($attributes, $name = 'custom_attributes')
    {
        $data = [];

        foreach ($attributes as $attribute) {
            $code        = $attribute->attribute_code;
            $value       = $attribute->value;
            $data[$code] = $value;
        }

        return (object) $data;
    }
}
