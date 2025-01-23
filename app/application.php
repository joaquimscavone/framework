<?php

require_once "../vendor/autoload.php";
use Fmk\Initialize;
use App\Models\Config;
use Fmk\Utils\Router;
Initialize::run();
// Initialize::createConstants(Config::all());
Initialize::createConstants(include "Configs/app.php");
Router::defineError404(function ($msg) {
  return view('errors.404',['msg'=>$msg], 'errors');
});
Router::defineError403(function ($msg) {
  return view('errors.403',['msg'=>$msg], 'errors');
});