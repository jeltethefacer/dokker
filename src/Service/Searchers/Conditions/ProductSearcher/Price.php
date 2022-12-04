<?php

namespace App\Service\Searchers\Conditions\ProductSearcher;

use App\Service\Searchers\Conditions\FloatCondition;
use Doctrine\ORM\QueryBuilder;

class Price extends FloatCondition
{
    /**
     * @param QueryBuilder $query_builder
     * @return QueryBuilder
     */
    public function addCondition(QueryBuilder $query_builder): QueryBuilder
    {
        return $query_builder->andWhere('p.price_minor_amount = :price_minor_amount')
            ->setParameter(':price_minor_amount', ((int) ($this->param * 100)));
    }
}
