<?php

namespace ahmetbarut\Validation\Validation\Rules;

use ahmetbarut\Validation\Validation\Rule;

class Number implements Rule
{

    public function check(string $attr, string $value): bool
    {
        if (is_numeric($value) === true) {
            return true;
        }
        return false;
    }

    public function message(): string
    {
        return "Sayısal olmalıdır!";
    }
}
