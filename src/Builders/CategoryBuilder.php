<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-06-14 15:54:35
 */

namespace Diepxuan\Magento\Builders;

use Diepxuan\Magento\Exceptions\MagentoClientException;
use Diepxuan\Magento\Exceptions\MagentoRequestException;
use Diepxuan\Magento\Models\Category;
use Diepxuan\Magento\Models\Model;
use Illuminate\Support\Collection;

class CategoryBuilder extends Builder
{
    protected $entity = 'categories';
    protected $model  = Category::class;

    /**
     * @param array $filters
     *
     * @return Collection|Model[]
     *
     * @throws MagentoClientException
     * @throws MagentoRequestException
     */
    public function get($filters = [])
    {
        $urlFilters = $this->parseFilters($filters);

        return $this->request->handleWithExceptions(function () use ($urlFilters) {
            $response     = $this->request->client->get("categories/list{$urlFilters}");
            $responseData = json_decode((string) $response->getBody());

            return $this->parseResponse($responseData);
        });
    }
}
