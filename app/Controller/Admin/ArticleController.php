<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\Article;

class ArticleController extends ControllerAbstract
{

    public function getArticleList(){
        $article = new Article();
        $result = $article->getArticleList($this->request()->post);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }

    public function getArticleItem(){
        $article = new Article();
        $result = $article->getArticleItem($this->request()->post);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }
    public function setArticleStatus(){
        $article = new Article();
        $result = $article->setArticleStatus($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $article->error, 'data' => '']);
        }
    }
    public function setArticleItem(){
        $article = new Article();
        $result = $article->setArticleItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $article->error, 'data' => '']);
        }
    }
    public function addArticleItem(){
        $article = new Article();
        $result = $article->addArticleItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $article->error, 'data' => '']);
        }
    }
    public function setArticleTop(){
        $article = new Article();
        $result = $article->setArticleTop($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $article->error, 'data' => '']);
        }
    }
    public function delArticleList(){
        $article = new Article();
        $result = $article->delArticleList($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $article->error, 'data' => '']);
        }
    }
}