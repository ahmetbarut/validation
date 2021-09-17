<?php

namespace ahmetbarut\Http\Validation\Rules;

class Required implements Rule
{

    public function check($attr, $value): bool
    {
        return !empty($value);
    }

    public function message(): string
    {
        return "eeeee";
    }
}