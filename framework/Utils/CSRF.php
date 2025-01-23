<?php

namespace Fmk\Utils;

class CSRF{
    protected static $instance;
    protected $hash;

    const TOKEN_NAME = 'csrf_token';

    protected function __construct(){
        $session = Session::getInstance();
        if(!isset($session->{self::TOKEN_NAME})){
            $session->{self::TOKEN_NAME} = base64_encode(random_bytes(32));
        }
        $this->hash = $session->{self::TOKEN_NAME};
    }

    protected static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self;
        }
        return self::$instance;
    }


    public static function token(){
        return self::getInstance()->hash;
    }

    public static function check($hash){
        return self::getInstance()->hash === $hash;
    }
}
