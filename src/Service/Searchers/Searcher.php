<?php

namespace App\Service\Searchers;

use App\Service\Searchers\Conditions\Condition;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\QueryBuilder;

abstract class Searcher
{
    /** @var $conditions Condition[]  */
    private array $conditions = [];

    /**
     * @param Condition $condition
     * @return $this
     */
    public function addCondition(Condition $condition): self
    {
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * @param QueryBuilder $query_builder
     * @return QueryBuilder
     */
    protected function addConditionsToQueryBuilder(QueryBuilder $query_builder): QueryBuilder
    {
        foreach ($this->conditions as $condition) {
            $query_builder = $condition->addCondition($query_builder);
        }
        return $query_builder;
    }

    /**
     * @return Entity[]
     */
    abstract function getResults(): array;
}
