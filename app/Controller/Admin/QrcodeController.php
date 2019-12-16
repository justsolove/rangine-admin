<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\Help;
use W7\Http\Message\Server\Request;

class QrcodeController extends ControllerAbstract
{


    /**
     * 根据路由获取帮助
     */
    public function callurl(){

        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => ['call_url' => '']]);
    }



}