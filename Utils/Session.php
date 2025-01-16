<?php

namespace Fmk\Utils;

use Fmk\Interfaces\Auth;
class Session
{
    protected static $instance;

    const DATA_KEY = 'data';
    const USER_KEY = 'user';

    const REQUEST_KEY = 'request';
    const REQUEST_OLD_KEY = 'request_old';

    protected function __construct()
    {
        if (defined('SESSION_NAME')) {
            session_name(constant('SESSION_NAME'));
        } elseif (defined('APPLICATION_NAME')) {
            session_name(urlencode(constant('APPLICATION_NAME')));
        }
        session_start();
        $this->init();
    }

    protected function init()
    {
        if (!array_key_exists(self::DATA_KEY, $_SESSION)) {
            $_SESSION[self::DATA_KEY] = [];
        }
    }



    public function __get($name)
    {
        return $_SESSION[self::DATA_KEY][$name] ?? null;
    }
    public function __isset($name)
    {
        return isset($_SESSION[self::DATA_KEY][$name]);
    }
    public function __unset($name)
    {
        unset($_SESSION[self::DATA_KEY][$name]);
    }
    public function __set($name, $value)
    {
        $_SESSION[self::DATA_KEY][$name] = $value;
    }


    public function flush($name)
    {
        $flush = $this->$name;
        unset($this->$name);
        return $flush;
    }





    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }


    public function userRegister(Auth $user)
    {
        if(!$this->isLogged()){
            $_SESSION[self::USER_KEY] = $user;
            return true;
        }
        return false;
    }
    public function userUnregister()
    {
        if ($this->isLogged()) {
            $user = $_SESSION[self::USER_KEY];
            unset($_SESSION[self::USER_KEY]);
            return $user;
        }
        return false;

    }

    public function isLogged()
    {
        isset($_SESSION[self::USER_KEY]);
    }

    public function getUser(){
        return $_SESSION[self::USER_KEY] ?? false;
    }

    public function requestRegister(){
        $_SESSION[self::REQUEST_OLD_KEY] = $this->request();
        $_SESSION[self::REQUEST_KEY] = Request::getInstance();
    }

    public function request(){
        return $_SESSION[self::REQUEST_KEY] ?? null;
    }
    
    public function requestOld(){
        return $_SESSION[self::REQUEST_OLD_KEY] ?? null;
    }

}