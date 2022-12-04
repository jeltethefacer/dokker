<?php

namespace App\Service\Searchers\Conditions;


abstract class StringCondition extends Condition
{
    protected string $param;

    /**
     * @param string $param
     */
    public function __construct(string $param)
    {
        $this->param = $param;
    }

    protected function getLike(): string
    {
        return '%' . $this->param . '%';
    }
}
