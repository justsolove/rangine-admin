<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/13
 * Time: 14:23
 */

namespace W7\App\Controller\Wxapp;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Service\Upload;

class UploadController  extends ControllerAbstract {

    /**
     * 获取token
     */
    public function upload(){
        $upload = new Upload();
        $result = $upload->addUploadList('wxapp');
        if($result !== false){
            return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $upload->error, 'data' => $result]);
        }

    }

}