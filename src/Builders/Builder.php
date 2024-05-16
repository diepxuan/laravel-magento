<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-16 11:17:58
 */

namespace Diepxuan\Magento\Builders;

use Diepxuan\Magento\Exceptions\MagentoClientException;
use Diepxuan\Magento\Exceptions\MagentoRequestException;
use Diepxuan\Magento\Http\Request;
use Diepxuan\Magento\Models\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Builder
{
    protected $entity;

    /** @var Model */
    protected $model;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

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
            $response     = $this->request->client->get("{$this->entity}{$urlFilters}");
            $responseData = json_decode((string) $response->getBody());

            return $this->parseResponse($responseData);
        });
    }

    public function find($id)
    {
        return $this->request->handleWithExceptions(function () use ($id) {
            $response     = $this->request->client->get("{$this->entity}/{$id}");
            $responseData = json_decode((string) $response->getBody());

            return new $this->model($this->request, $responseData);
        });
    }

    public function create($data)
    {
        $data = [
            Str::singular($this->entity) => $data,
        ];

        return $this->request->handleWithExceptions(function () use ($data) {
            $response = $this->request->client->post("{$this->entity}", [
                'json' => $data,
            ]);

            $responseData = json_decode((string) $response->getBody());

            return new $this->model($this->request, $responseData);
        });
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity($new_entity)
    {
        $this->entity = $new_entity;

        return $this->entity;
    }

    protected function parseFilters($filters)
    {
        $urlFilters = '?searchCriteria';
        $count      = \count($filters);
        if ($count > 0) {
            foreach ($filters as $index => $filter) {
                $conditionType = $filter['condition_type'] ?? 'eq';

                $urlFilters .= "[filter_groups][{$index}][filters][0][field]={$filter['field']}";
                $urlFilters .= '&searchCriteria';
                $urlFilters .= "[filter_groups][{$index}][filters][0][value]={$filter['value']}";
                $urlFilters .= '&searchCriteria';
                $urlFilters .= "[filter_groups][{$index}][filters][0][condition_type]={$conditionType}";
                $urlFilters .= ($count > 1 && ($index < $count - 1)) ? '&searchCriteria' : '';
            }
        } else {
            $urlFilters .= '=[]';
        }

        return $urlFilters;
    }

    protected function parseResponse($response)
    {
        $fetchedItems = collect($response->items);
        $items        = collect([]);

        foreach ($fetchedItems as $index => $item) {
            /** @var Model $model */
            $model = new $this->model($this->request, $item);

            $items->push($model);
        }

        return $items;
    }
}
