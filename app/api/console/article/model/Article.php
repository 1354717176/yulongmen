<?php

namespace app\api\console\article\model;

use think\Model;

class Article extends Model
{
    protected $autoWriteTimestamp = 'datetime';
    protected $insert = ['ip'];

    protected function setIpAttr()
    {
        return request()->ip();
    }

    public function articleData()
    {
        return $this->hasOne('ArticleData','id');
    }
}