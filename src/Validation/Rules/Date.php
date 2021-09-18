<?php

namespace ahmetbarut\Validation\Validation\Rules;

use ahmetbarut\Validation\Validation\Rule;
use DateTime;

class Date implements Rule
{
    public function check($attr, $value): bool
    {

        return DateTime::createFromFormat("d/m/Y", $value) === false
            ? false
            : true;
    }

    public function message(): string
    {
        return "Tarih formatına uymalı. Kabul edilen format:(01/01/9999).";
    }
}
