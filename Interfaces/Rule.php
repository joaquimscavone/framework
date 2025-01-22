<?php

namespace Fmk\Interfaces;

interface Rule{
    public function passes(&$value):bool;

    public function error($attribute):string;
}