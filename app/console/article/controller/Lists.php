<?php

namespace app\console\article\controller;

use app\api\common\logic\Base;

/**
 * 文章列表页
 * Class Index
 * @package app\console\article\controller
 */
class Lists extends Base
{
    public function index()
    {
        return $this->fetch();
    }
}