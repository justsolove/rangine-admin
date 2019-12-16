<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\Withdraw;

class WithdrawController extends ControllerAbstract
{


    /**
     * 根据路由获取帮助
     */
    public function drawList(){
        $params = $this->request()->post;
        $draw = new Withdraw();
        $result = $draw->getWithdrawList($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }



}