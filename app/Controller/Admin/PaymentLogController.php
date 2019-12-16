<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\PaymentLog;

class PaymentLogController extends ControllerAbstract
{

    /**
     * 用户获取未读消息数
     * @access public
     * @param  array $data 外部数据
     * @return false|array
     * @throws
     */
    public function paymentlogList(){
        $payment = new PaymentLog();
        $params = $this->request()->post;
        $result = $payment->getPaymentLogList($params);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }


}