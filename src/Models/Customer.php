<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-14 17:37:56
 */

namespace Diepxuan\Magento\Models;

class Customer extends Model
{
    protected $entity     = 'customers';
    protected $primaryKey = 'id';

    public function getBillingAddress()
    {
        return $this->request->handleWithExceptions(function () {
            $address      = $this->request->client->get("{$this->entity}/{$this->{$this->primaryKey}}/billingAddress");
            $responseData = json_decode((string) $address->getBody());

            if (!empty($responseData)) {
                return new CustomerAddress($this->request, $responseData);
            }

            return null;
        });
    }

    public function getShippingAddress()
    {
        return $this->request->handleWithExceptions(function () {
            $address      = $this->request->client->get("{$this->entity}/{$this->{$this->primaryKey}}/shippingAddress");
            $responseData = json_decode((string) $address->getBody());

            if (!empty($responseData)) {
                return new CustomerAddress($this->request, $responseData);
            }

            return null;
        });
    }
}
