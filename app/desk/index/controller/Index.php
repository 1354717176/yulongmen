<?php

namespace app\desk\index\controller;

use app\api\common\logic\Deskbase;
use app\api\console\article\model\Article;


/**
 * 网站首页类
 * Class Index
 * @author yanghuan
 * @datetime 2017/3/20 19:47
 * @package app\desk\sign\controller
 */
class Index extends Deskbase
{

    /**
     * 网站首页
     * @author:yanghuna
     * @datetime:2017/3/29 19:45
     * @return mixed
     */
    public function index()
    {
        $articleList = Article::where(['status'=>0,'catid'=>['in',[3]]])->limit(15)->order('id desc')->select()->toArray();
        $list1 = $list2 = $list3=[];
        if($articleList){
            foreach ($articleList as $key=>$item){
                $item['create_time'] = date('Y-m-d',strtotime($item['create_time']));
                if($key>=0 && $key<=4){
                    $list1[]=$item;
                }
                if($key>=5 && $key<=9){
                    $list2[]=$item;
                }
                if($key>=10 && $key<=14){
                    $list3[]=$item;
                }
            }
        }
        $this->assign('list1',$list1);
        $this->assign('list2',$list2);
        $this->assign('list3',$list3);

        $about = Article::where(['status'=>0,'catid'=>6])->find();
        $this->assign('about',$about);
        return $this->fetch();
    }
}