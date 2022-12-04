<?php

namespace App\Service\Searchers\Conditions\ProductSearcher;

use App\Service\Searchers\Conditions\StringCondition;
use Doctrine\ORM\QueryBuilder;

/**
 *
 */
class Name extends StringCondition
{
    /**
     * @param QueryBuilder $query_builder
     * @return QueryBuilder
     */
    public function addCondition(QueryBuilder $query_builder): QueryBuilder
    {
        return $query_builder->andWhere('LOWER(p.name) LIKE LOWER(:name)    ')
            ->setParameter(':name', $this->getLike());
    }
}
