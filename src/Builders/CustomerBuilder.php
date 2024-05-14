<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-14 17:40:02
 */

namespace Diepxuan\Magento\Builders;

use Diepxuan\Magento\Models\Customer;

class CustomerBuilder extends Builder
{
    protected $entity = 'customers';
    protected $model  = Customer::class;

    public function get($filters = [])
    {
        $urlFilters = $this->parseFilters($filters);

        return $this->request->handleWithExceptions(function () use ($urlFilters) {
            $response     = $this->request->client->get("{$this->entity}/search{$urlFilters}");
            $responseData = json_decode((string) $response->getBody());

            return $this->parseResponse($responseData);
        });
    }
}
