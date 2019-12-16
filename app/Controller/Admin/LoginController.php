<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\Admin;
use W7\Http\Message\Server\Request;

class LoginController extends ControllerAbstract
{
    /**
     * 登录页面
     * @return \W7\Http\Message\Server\Response
     */
    public function index(){
        return $this->responseJson(['jhg']);
    }

    /**
     * 登录验证
     */
    public function chack(){
        $params = $this->request()->post;
        $data = [
            'username' => $params['username'],
            'password' => $params['password'],
            'platform' => 'admin'
        ];
        $login = new Admin();
        $result = $login->loginAdmin($data);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }
    /**
     * 注销登录
     */
    public function logout(){
        $params = $this->request()->post;
        $login = new Admin();
        $result = $login->logoutAdmin($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }


}