<?php 

namespace ahmetbarut\Http\Input;

interface InputInterface
{
    /**
     * Open PUT stream
     *
     * @return InputInterface
     */
    public function open(): InputInterface;

    /**
     * Read PUT stream
     *
     * @return InputInterface
     */
    public function read(): InputInterface;

    /**
     * Return the open stream in object
     *
     * @return object
     */
    public function get(): object;

}