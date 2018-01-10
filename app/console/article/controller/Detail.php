<?php

namespace app\console\article\controller;

use app\api\common\logic\Base;
use app\api\console\cate\logic\Cate;
use app\api\console\cate\service\Cate AS serviceCate;
use app\api\console\article\model\Article AS modelArticle;
use app\api\console\article\model\ArticleData AS modelArticleData;
use think\Db;
use Think\Exception;

class Detail extends Base
{
    public function index()
    {
        $fields = 'id,name,icon,parent_id,status';
        $map = [
            'status' => ['in', '0'],
            'type' => 1,
        ];
        $order = 'id desc';

        $cate = new Cate;
        $cateList = $cate->getList($fields, $map, $order);

        $data['id']=$this->request->param('id',0);
        $catid=0;
        if($data['id']){
            $article = modelArticle::get($data['id']);
            $catid= $article['catid'];
            $article['content'] = $article->articleData->content;
            $this->assign('article',$article);
        }
        $serviceCate = new serviceCate;
        $list = $serviceCate->getSelectDom($cateList,$catid);
        $this->assign('cate', $list);


        return $this->fetch();
    }

    public function save()
    {

        if($this->request->isPost()){

            $data['id'] = $this->request->post('id', 0);
            $data['catid'] = $this->request->post('catid', 0);
            $data['title'] = $this->request->post('title', '');
            $data['introduce'] = $this->request->post('introduce', '');
            $data['hits'] = $this->request->post('hits', '');

            $file = $this->request->file('img');
            if($file){
                $imgPath = upload($file,441,238);
                if ($imgPath['code']) {
                    return json($imgPath);
                }
                $data['thumb'] = $imgPath['data'];
            }

            if($data['id']){
                Db::startTrans();
                try {
                    modelArticle::update($data);

                    $content['content'] = $this->request->post('content', '');
                    $content['id'] = $data['id'];
                    modelArticleData::update($content);
                    Db::commit();
                    return json(['code' => 0, 'msg' => '操作成功', 'data' => []]);
                } catch (Exception $e) {
                    Db::rollback();
                    return json(['code' => 1, 'msg' => $e->getMessage(), 'data' => []]);
                }
            }else{

                unset($data['id']);
                Db::startTrans();
                try {
                    $article = modelArticle::create($data);

                    $content['content'] = $this->request->post('content', '');
                    $content['id'] = $article->id;
                    modelArticleData::create($content);
                    Db::commit();
                    return json(['code' => 0, 'msg' => '操作成功', 'data' => []]);
                } catch (Exception $e) {
                    Db::rollback();
                    return json(['code' => 1, 'msg' => $e->getMessage(), 'data' => []]);
                }
            }
        }
    }

    public function status()
    {
        if ($this->request->post()) {
            $data['id'] = $this->request->post('id', 0);
            $data['status'] = $this->request->post('status', 0);
            modelArticle::update($data);
            return json(['code' => 0, 'msg' => '操作成功', 'data' => []]);
        }
        return json(['code' => 1, 'msg' => '请求错误', 'data' => []]);
    }
}