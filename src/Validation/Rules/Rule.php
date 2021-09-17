<?php

namespace ahmetbarut\Http\Validation\Rules;

interface Rule
{
    public function check($attr, $value): bool;

    public function message(): string;
}