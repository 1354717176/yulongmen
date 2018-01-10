<?php

namespace app\desk\detail\controller;

use app\api\common\logic\Deskbase;
use app\api\console\article\model\Article AS modelArticle;
use app\api\console\article\model\ArticleData AS modelArticleData;

class About extends Deskbase
{
    public function index()
    {
        $catId = $this->request->param('cat_id', 0);
        $article = modelArticle::where('catid', $catId)->find();
        if (!is_null($article)) {
            $content = modelArticleData::where('id', $article['id'])->value('content');
            $article['content'] = $content;
        }
        $this->assign('article', $article);
        return $this->fetch();
    }

    public function news(){
        $catId = $this->request->param('id', 0);
        $article = modelArticle::where('id', $catId)->find();
        if (!is_null($article)) {
            $content = modelArticleData::where('id', $article['id'])->value('content');
            $article['content'] = $content;
        }
        $this->assign('article', $article);
        return $this->fetch();
    }
}