<?php
require_once "../app/application.php";
use Fmk\Utils\Request;
echo Request::exec();


// echo Router::getRouteByName('funcionario.gorjeta')
// ->setParamns(['funcionario_id'=>15,'data'=>date("Y-m-d")]);

