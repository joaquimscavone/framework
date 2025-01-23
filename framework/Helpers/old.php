<?php

if(!function_exists('old')){
    function old($name,$default = ''){
        $request = session()->requestOld();
        return (isset($request->$name))?$request->$name:$default;
    }
}