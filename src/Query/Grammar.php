<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-08 09:32:01
 */

namespace Diepxuan\Magento\Query;

class Grammar
{
    public array $mapping = [
        '='  => 'eq',
        '<'  => 'lt',
        '>'  => 'gt',
        '<=' => 'lteq',
        '>=' => 'gteq',
        '<>' => 'neq',
        '!=' => 'neq',
    ];

    public function getOperator(string $operator): string
    {
        return $this->mapping[$operator] ?? $operator;
    }
}
