<?php

namespace ahmetbarut\Validation\Validation\Rules;

use ahmetbarut\Validation\Validation\Rule;

class Test implements Rule
{
    public function __construct(protected $limit)
    {
        
    }
    
    public function check($attr, $value): bool
    {
        return false;
    }

    public function message(): string
    {
        return "deneme test ediliyor. : {$this->limit}";
    }
}
