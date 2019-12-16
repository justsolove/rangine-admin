<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\Storage;

class StorageController extends ControllerAbstract
{


    /**
     * 根据路由获取帮助
     */
    public function directorySelect(){
        $params = $this->request()->post;
        $login = new Storage();
        $result = $login->getStorageDirectorySelect($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }

    /**
     * 图片列表
     */
    public function imgList(){
        $storage = new Storage();
        $result = $storage->getImgList($this->request()->post);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }
    /**
     * 删除图片
     */
    public function delImg(){
        $storage = new Storage();
        $result = $storage->delImg($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $result->error, 'data' => '']);
        }
    }


}