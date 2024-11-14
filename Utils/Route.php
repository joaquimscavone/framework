<?php

namespace Fmk\Utils;

class Route
{
    protected string $uri;

    protected $callback;

    protected array $paramns;

    protected string $method;

    protected string $name;

    public function __construct($name, $uri, $method, $callback)
    {
        $this->name = $name;
        $this->uri = $uri;
        $this->method = $method;
        $this->callback = $callback;
        $this->paramns = array_fill_keys($this->checkParamns($uri),null);
    }

    protected function checkParamns($uri)
    {
        if(preg_match_all("(\{[a-z0-9_]{1,}\})",$uri,$m)){
           return preg_replace("(\{|\})","",$m[0]);
        }
        return [];
    }


    public function name($name){
        if(Router::swapName($this->name, $name)){
            $this->name = $name;
            return $this;
        }
        throw new \Exception("Erro ao trocar o nome da rota $this->name");
    }

    public function setParamns(array $paramns = []){
        foreach($paramns as $key => $value){
            if(array_key_exists($key,$this->paramns)){
                $this->paramns[$key] = $value;
            }
        }
        return $this;
    }

    public function defineParameters(array $paramns = []){
        foreach($this->paramns as &$paramn){
            $value = array_shift($paramns);
            if(is_null($value)){
                break;
            }
            $paramn = urldecode($value);
        }
    }

    public function getUrl(array $paramns = []){
        $this->setParamns($paramns);
        $base_url = defined("APPLIATION_URL") ? constant("APPLICATION_URL") : "";
        $base_url = preg_replace("/\/$/",'',$base_url);
        $url = $this->uri;
        foreach($this->paramns as $key => $value){
            $url = str_replace("{{$key}}",urlencode($value),$url);
        }
        return $base_url.$url;
    }

    public function __toString(){
        return $this->getUrl();
    }

    //function juca($nome) ['apelido'=>'abjsfd']
    public function exec(){
        $callback = $this->callback;
        if(is_array($callback) && !is_object($callback[0])){
            $callback[0] = new $callback[0];
        }
        return call_user_func_array($callback, $this->paramns);
    }

    public function getMethod(){
        return $this->method;
    }
    public function getUri(){
        return $this->uri;
    }

    public function redirect(){
        header("Location: $this");
        exit;
    }
}