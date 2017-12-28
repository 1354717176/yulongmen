<?php

namespace app\desk\article\controller;

use app\api\common\logic\Deskbase;

class Lists extends Deskbase
{
    public function index(){
        return $this->fetch();
    }

    public function news(){
        return $this->fetch();
    }
}