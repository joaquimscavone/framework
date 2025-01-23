<?php

namespace Fmk\Interfaces;

interface Middleware{

    /**
     * condição que verifica se o middleware será aprovado no teste: True Middleware aprovado; False Middleware reprovado execute o handle;
     * @return bool
     */
    public function check():bool;

    /**
     * procedimento que deve ser executado caso o middleware não seja aprovado no check.
     * @return mixed
     */
    public function handle();
}