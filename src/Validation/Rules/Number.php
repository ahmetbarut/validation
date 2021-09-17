<?php

namespace ahmetbarut\Http\Validation\Rules;

class Number implements Rule
{

    public function check($attr, $value): bool
    {
        return is_numeric($value);
    }

    public function message(): string
    {
        return "Numara olmalıdır !";
    }
}