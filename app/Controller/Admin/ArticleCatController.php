<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\ArticleCat;

class ArticleCatController extends ControllerAbstract
{

    public function getArticleCatList(){
        $articleCatId = 0;
        $isLayer = false;
        $level = null;
        $articleCata = new ArticleCat();
        !isset($this->request()->post['level']) ?: $level = $this->request()->post['level'];
        !isset($this->request()->post['article_cat_id']) ?: $articleCatId = $this->request()->post['article_cat_id'];
        empty($this->request()->post['is_layer']) ?: $isLayer = true;
        $isNavi = is_empty_parm($this->request()->post['is_navi']) ? null : $this->request()->post['is_navi']; // 处理是否过滤导航
        $result = $articleCata->getArticleCatList($articleCatId, $isLayer, $level, $isNavi);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }

    public function setArticleCatItem(){
        $articleCat = new ArticleCat();
        $result = $articleCat->setArticleCatItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $articleCat->error, 'data' => '']);
        }
    }
    public function addArticleCatItem(){
        $articleCat = new ArticleCat();
        $result = $articleCat->addArticleCatItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $articleCat->error, 'data' => '']);
        }
    }
    public function delArticleCatList(){
        $articleCat = new ArticleCat();
        $result = $articleCat->delArticleCatList($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $articleCat->error, 'data' => $result]);
        }
    }
}