<?php

namespace App\Service\Searchers\Conditions;

abstract class FloatCondition extends Condition
{
    protected float $param;

    /**
     * @param float $param
     */
    public function __construct(float $param)
    {
        $this->param = $param;
    }
}
