<?php

namespace App\Service\Searchers\Conditions;

use Doctrine\ORM\QueryBuilder;

abstract class Condition
{
    abstract public function addCondition(QueryBuilder $query_builder): QueryBuilder;
}
