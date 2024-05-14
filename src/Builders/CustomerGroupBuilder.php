<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-14 17:39:56
 */

namespace Diepxuan\Magento\Builders;

use Diepxuan\Magento\Models\CustomerGroup;

class CustomerGroupBuilder extends Builder
{
    protected $entity = 'customerGroups';
    protected $model  = CustomerGroup::class;

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
