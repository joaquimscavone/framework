<?php

namespace App\Controllers;

use App\Models\Atendimento;
use Fmk\MVC\Controller;

class HomeController extends Controller{
    public function index(){
        return view('mesas',
        ['mesas'=>Atendimento::getMesas()],
        'main');
    }
}