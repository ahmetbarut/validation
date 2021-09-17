<?php

namespace ahmetbarut\Http\Validation;

use ahmetbarut\Http\Input\InputInterface;
use ahmetbarut\Http\Validation\Rules\Rule;
use http\Exception\InvalidArgumentException;
use ReflectionClass;

class Validate
{
    public $parameters = [];

    public $rules = [];

    public $fields = [];

    protected $classes = [
        "required" => \ahmetbarut\Http\Validation\Rules\Required::class,
        "number" => \ahmetbarut\Http\Validation\Rules\Number::class,
    ];

    private $input;

    public function __construct($input, array $rules = [])
    {
        $this->isInstanceOfRules($rules);

        $this->classes = array_merge($this->classes, $rules);

        $this->input = $input;

        $this->parse();
    }

    public function parse()
    {
        foreach ($this->input as $key => $values) {
            $this->parameters[$key] = $values;
        }
    }

    /**
     * @param  array  $rules
     * @return Validate
     */
    public function setRules(array $rules): static
    {
        $this->rules = $rules;
        return $this;
    }

    public function setFields(...$fields): static
    {
        $this->fields = $fields;
        return $this;
    }
    
    public function make(): string|bool
    {
        foreach ($this->rules as $key => $rule) {
            
            $getRuleClass = (new $this->classes[$rule]);

            if (false === $getRuleClass->check($key, $this->parameters[$key])) {
                return $getRuleClass->message();
            }
            return true;
        }
    }

    public function isInstanceOfRules (array $instance)
    {
        foreach ($instance as $key => $class) {
            $r = new ReflectionClass($class);
            if ((new $class instanceof Rule) === false) {
                throw new \InvalidArgumentException(sprintf("%s, not implemented ahmetbarut\Validation\Rules\Rule", $class));
            }
        }
    }
}
