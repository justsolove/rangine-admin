<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\Ask;


class AskController extends ControllerAbstract
{


    /**
     * 根据路由获取帮助
     */
    public function askList(){
        $params = $this->request()->post;
        $ask = new Ask();
        $result = $ask->getAskList($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }
    /**
     * 删除咨询
     */
    public function askDelete(){
        $params = $this->request()->post;
        $ask = new Ask();
        $result = $ask->delAskItem($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }
    /**
     * 获取咨询详情
     */
    public function askItem(){
        $params = $this->request()->post;
        $ask = new Ask();
        $result = $ask->getAskItem($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }



}