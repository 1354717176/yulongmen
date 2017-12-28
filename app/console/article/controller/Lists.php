<?php

namespace app\console\article\controller;

use app\api\common\logic\Base;
use app\api\console\article\model\Article AS modelArticle;
use app\api\console\cate\model\Cate AS modelCate;

/**
 * 文章列表页
 * Class Lists
 * @package app\console\article\controller
 */
class Lists extends Base
{
    public function index()
    {
        $pageSize = $this->request->get('pagesize',20);
        $lists = [];

        $result = modelArticle::where(['status'=>0])->order('id DESC')->paginate($pageSize);
        if($result){
            $cateName=[];
            $cateArr = $result->toArray();
            $catid = array_column($cateArr['data'],'catid');
            $cate = modelCate::where('id','IN',$catid)->field('id,name')->select()->toArray();
            if($cate){
                $cateName = array_column($cate,'name','id');
            }
            foreach ($result as $item){
                $item['cate'] = isset($cateName[$item['catid']]) ? $cateName[$item['catid']] : '';
                $lists[]=$item;
            }
        }
        $this->assign('lists',$lists);
        $this->assign('pages',$result->render());

        return $this->fetch();
    }
}