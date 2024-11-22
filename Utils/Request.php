<?php

namespace Fmk\Utils;

class Request{
    protected static $instance;

    protected $uri;

    protected $method;

    protected $data;

    const REQUEST_KEY = 'request_uri';

    protected $session;

    protected function __construct(){
        $this->session = Session::getInstance();
        $this->uri = $_REQUEST[static::REQUEST_KEY] ?? "/";
        $this->method = $_SERVER['REQUEST_METHOD'];
        $data = $_REQUEST;
        unset($data[static::REQUEST_KEY]);
        $this->data = $data;
    }


    public function __get($name){
        $this->data[$name] ?? null;
    }

    public function __isset($name){
        return isset($this->data[$name]);
    }


    public static function getInstance(){
        if(is_null(static::$instance)){
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function getUri(){
        return $this->uri;
    }

    public function getMethod(){
        return $this->method;
    }


    public function getRoute(){
        return Router::getRouteByUri($this->uri,$this->method);
    }

    public static function route(){
        return static::getInstance()->getRoute();
    }


}