<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-08 08:44:16
 */

namespace Diepxuan\Magento\Query;

class SearchCriteria
{
    public array $pagination = [];

    public array $select = [];

    public array $wheres = [];

    public array $orders = [];

    protected int $currentFilterGroup = 0;

    protected int $currentFilterIndex = 0;

    public function __construct(
        protected Grammar $grammar
    ) {}

    public function paginate(int $page, int $pageSize): static
    {
        $this->pagination = [
            'searchCriteria[pageSize]'    => $pageSize,
            'searchCriteria[currentPage]' => $page,
        ];

        return $this;
    }

    public function select(array|string $fields): static
    {
        $this->select['fields'] = \is_array($fields)
            ? implode(',', $fields)
            : $fields;

        return $this;
    }

    public function where(
        string $field,
        string $operator,
        mixed $value = null,
        ?int $filterGroup = null,
        int $filterIndex = 0
    ): static {
        // Assume the operator is equals
        if (null === $value) {
            $value    = $operator;
            $operator = '=';
        }

        return $this->addWhere($field, $operator, $value, $filterGroup, $filterIndex);
    }

    public function orWhere(string $field, string $operator, mixed $value = null): static
    {
        ++$this->currentFilterIndex;

        $this->where(
            $field,
            $operator,
            $value,
            $this->currentFilterGroup > 0 ? $this->currentFilterGroup - 1 : 0,
            $this->currentFilterIndex
        );

        return $this;
    }

    public function whereIn(string $field, array $values): static
    {
        return $this->addWhere($field, 'in', implode(',', $values));
    }

    public function orWhereIn(string $field, array $values): static
    {
        ++$this->currentFilterIndex;

        return $this->addWhere(
            $field,
            'in',
            implode(',', $values),
            $this->currentFilterGroup > 0 ? $this->currentFilterGroup - 1 : 0,
            $this->currentFilterIndex
        );
    }

    public function whereNotIn(string $field, array $values): static
    {
        return $this->addWhere($field, 'nin', implode(',', $values));
    }

    public function orWhereNotIn(string $field, array $values): static
    {
        ++$this->currentFilterIndex;

        return $this->addWhere(
            $field,
            'nin',
            implode(',', $values),
            $this->currentFilterGroup > 0 ? $this->currentFilterGroup - 1 : 0,
            $this->currentFilterIndex
        );
    }

    public function whereNull(string $field): static
    {
        return $this->addWhere($field, 'null');
    }

    public function orWhereNull(string $field): static
    {
        ++$this->currentFilterIndex;

        return $this->addWhere(
            $field,
            'null',
            null,
            $this->currentFilterGroup > 0 ? $this->currentFilterGroup - 1 : 0,
            $this->currentFilterIndex
        );
    }

    public function whereNotNull(string $field): static
    {
        return $this->addWhere($field, 'notnull');
    }

    public function orWhereNotNull(string $field): static
    {
        ++$this->currentFilterIndex;

        return $this->addWhere(
            $field,
            'notnull',
            null,
            $this->currentFilterGroup > 0 ? $this->currentFilterGroup - 1 : 0,
            $this->currentFilterIndex
        );
    }

    public function orderBy(string $field, string $direction = 'ASC'): static
    {
        $index = \count($this->orders) / 2;

        $this->orders["searchCriteria[sortOrders][{$index}][field]"]     = $field;
        $this->orders["searchCriteria[sortOrders][{$index}][direction]"] = $direction;

        return $this;
    }

    public function orderByDesc(string $field): static
    {
        return $this->orderBy($field, 'DESC');
    }

    public function get(): array
    {
        return array_merge(
            $this->select,
            $this->wheres,
            $this->orders,
            $this->pagination,
        );
    }

    public function dd(): void
    {
        dd($this->get());
    }

    public static function make(): static
    {
        return app(static::class);
    }

    protected function addWhere(
        string $field,
        string $operator,
        mixed $value = null,
        ?int $filterGroup = null,
        int $filterIndex = 0
    ): static {
        $currentFilterGroup = $filterGroup ?? $this->currentFilterGroup;

        $prefix = "searchCriteria[filter_groups][{$currentFilterGroup}][filters][{$filterIndex}]";

        $this->wheres[$prefix . '[field]']          = $field;
        $this->wheres[$prefix . '[condition_type]'] = $this->grammar->getOperator($operator);

        if (null !== $value) {
            $this->wheres[$prefix . '[value]'] = $value;
        }

        if (null === $filterGroup) {
            ++$this->currentFilterGroup;
        }

        if (0 === $filterIndex) {
            $this->currentFilterIndex = 0;
        }

        return $this;
    }
}
