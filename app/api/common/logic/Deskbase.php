<?php

namespace app\api\common\logic;

use app\api\console\system\logic\Set as logicSet;
use app\api\console\cate\logic\Cate as logicCate;
use app\api\console\cate\service\Cate AS serviceCate;
use think\Controller;
use think\Config;

class Deskbase extends Controller
{
    public function _initialize()
    {

        $this->logicSet = new logicSet;
        $this->logicCate = new logicCate;
        $this->serviceCate = new serviceCate;

        $config = $this->logicSet->lists([3]);
        if ($config) {
            Config::set($config);
        }
        $this->assign(Config::get());

        //域名配置
        $domain = Config::get('domain');
        $this->assign('domain', $domain);

        $cateList = $this->cateList();
        $this->assign('cate', $cateList);
    }

    public function cateList()
    {
        $fields = 'id,name,icon,parent_id,status';
        $map = [
            'status' => ['in', '0'],
            'type' => 1,
        ];
        $order = 'id asc';
        $result = $this->logicCate->getList($fields, $map, $order);
        $lists = $this->serviceCate->getArrayDom($result);
        return $lists;
    }
}