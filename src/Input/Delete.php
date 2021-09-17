<?php 

namespace ahmetbarut\Http\Input;

use ahmetbarut\Http\Request;

class Delete implements InputInterface
{
    public $data;

    protected $stream;
    
    public function __construct(Request $request)
    {
        if($request->method() === "DELETE")
        {
            $this->open()->read()->get();
        }
    }

    /**
     * Undocumented function
     *
     * @return InputInterface
     */
    public function open(): InputInterface
    {
        $this->stream = fopen("php://input", "r");
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return InputInterface
     */
    public function read(): InputInterface
    {
        $this->data = (object) json_decode(fread($this->stream, 10000000)) ;

        fclose($this->stream);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return object
     */
    public function get(): object
    {
        return $this->data;
    }
    
}