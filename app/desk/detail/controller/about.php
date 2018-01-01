<?php
namespace app\desk\detail\controller;

use app\api\common\logic\Deskbase;

class About extends Deskbase
{
    public function index()
    {
        return $this->fetch();
    }
}