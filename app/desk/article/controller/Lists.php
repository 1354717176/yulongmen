<?php

namespace app\desk\article\controller;

use app\api\common\logic\Deskbase;
use app\api\console\article\model\Article;

class Lists extends Deskbase
{
    public function index()
    {
        $list = [];
        $articleList = Article::where(['status' => 0, 'catid' => ['in', [4, 15, 16, 17]]])->order('id desc')->paginate(4);
        if (!$articleList->isEmpty()) {
            foreach ($articleList as $item) {
                $item['small_thumb'] = '';
                if ($item['thumb']) {
                    $ext = explode('.', $item['thumb']);
                    $item['small_thumb'] = $ext[0].'.thumb.'.$ext[1];
                }
                $list[] = $item;
            }
        }
        $this->assign('article', $articleList);
        $this->assign('page', $articleList->render());
        return $this->fetch();
    }

    public function news()
    {
        $articleList = Article::where(['status' => 0, 'catid' => ['in', [3]]])->order('id desc')->paginate(15);
        $list1 = $list2 = $list3 = [];
        if (!$articleList->isEmpty()) {
            foreach ($articleList as $key => $item) {
                $item['formate_create_time'] = date('Y-m-d', strtotime($item['create_time']));
                if ($key >= 0 && $key <= 4) {
                    $list1[] = $item;
                }
                if ($key >= 5 && $key <= 9) {
                    $list2[] = $item;
                }
                if ($key >= 10 && $key <= 14) {
                    $list3[] = $item;
                }
            }
        }
        $this->assign('page', $articleList->render());
        $this->assign('list1', $list1);
        $this->assign('list2', $list2);
        $this->assign('list3', $list3);
        return $this->fetch();
    }
}