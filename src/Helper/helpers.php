<?php

function array_push_key(&$ref, $key, $value)
{
    if (isset($ref[$key])) {
        array_push($ref[$key], $value);
    } else {
        $ref[$key] = [$value];
    }
}