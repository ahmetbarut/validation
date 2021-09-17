<?php
declare(strict_types=1);

namespace ahmetbarut\Http;

use ahmetbarut\Http\Input\Delete;
use ahmetbarut\Http\Input\Put;
use mysql_xdevapi\Exception;

class Request 
{
    /**
     * Stored $_GET data.
     *
     * @var array
     */
    public $get;

    /**
     * Stored $_POST data.
     *
     * @var array
     */
    public $post;

    /**
     * Stored $_FILES data.
     *
     * @var array
     */
    public $files;
    
    /**
     * Stored $_COOKIE data.
     *
     * @var array
     */
    public $cookie;
    
    /**
     * Stored $_SESSION data.
     *
     * @var array
     */
    public $session;

    /**
     * Stored PUT HTTP method data.
     *
     * @var \ahmetbarut\Http\Input\Put
     */
    public Put $put;
    
    /**
     * Stored request url.
     *
     * @var string
     */
    public $url;
    
    /**
     * Stored request method.
     * @var string
     */
    public $method;

    protected $methods = ["GET", "POST", "DELETE", "PUT"];

    /**
     * Starting Request instance.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!in_array($this->method(), $this->methods)) {
            throw new \Exception(sprintf("%s method not supported", $this->method()));
        }

        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->cookie = $_COOKIE;
        $this->session = $_SESSION;
        $this->put = new Put($this);
        $this->delete = new Delete($this);
        $this->method = $this->method();
        $this->url = $this->uri();

    }
    
    /**
     * Get request url.
     *
     * @return string
     */
    public static function uri(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
        
        return rtrim($uri, "/") === "" ? "/" : rtrim($uri, "/");
    }

    /**
     * Get request method.
     *
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get request host.
     *
     * @return string
     */
    public static function httpReferer()
    {
        return  '//'. trim($_SERVER['HTTP_HOST'], '/');
    }
}