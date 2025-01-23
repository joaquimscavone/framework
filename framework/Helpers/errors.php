<?php

if(!function_exists('errors')){
    function errors($name){
        $request = Fmk\Utils\Session::getInstance()->requestOld();
        if($request){
            $validate = $request->getValidate($name);
            if($validate){
                return $validate->getErrors();
            }
        }
        return [];
    }
}
if(!function_exists('has_error')){
    function has_error($name, $callback = null){
        $request = Fmk\Utils\Session::getInstance()->requestOld();
        $error = false;
        if($request){
            $validate = $request->getValidate($name);
            if($validate){
               $error = !$validate->check();
            }
        }
        if(is_string($callback )){
            return ($error)?$callback:"";
        }else if(is_callable($callback)){
            return ($error)?$callback():false;
        }
        return $error;
    }
}