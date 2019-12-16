<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Service\Upload;
use W7\App\Model\Common\Storage;


class UploadController extends ControllerAbstract
{


    /**
     * 获取路由
     */
    public function uploadModule(){
        $params = $this->request()->post;
        $upload = new Upload();
        $result = $upload->getUploadModule($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }

    /**
     * 获取token
     */
    public function getToken(){
        $params = $this->request()->post;
        $upload = new Upload();
        $result = $upload->getUploadToken($params);
        if($result !== false){
            return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $upload->error, 'data' => $result]);
        }

    }
    /**
     * 获取token
     */
    public function upload(){
        $upload = new Upload();
        $result = $upload->addUploadList('admin');
        if($result !== false){
            return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $upload->error, 'data' => $result]);
        }

    }

    /**
     * 获取缩略图
     */
    public function thumb(){
        $upload = new Upload();
        $result = $upload->getThumb();
        if($result !== false){
            return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $upload->error, 'data' => $result]);
        }
    }



}