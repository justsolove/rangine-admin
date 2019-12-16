<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\User;

class UserController extends ControllerAbstract
{

    /**
     * 用户获取未读消息数
     * @access public
     * @param  array $data 外部数据
     * @return false|array
     * @throws
     */
    public function userList(){
        $group = new User();
        $params = $this->request()->post;
        $result = $group->getUserList($params);

        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }

    /**
     * 批量设置用户账户状态
     */
    public function userStatus(){
        $params = $this->request()->post;
        $group = new User();
        $result = $group->setUserStatus($params);

        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }

    /**
     * 批量删除用户
     * @return \W7\Http\Message\Server\Response
     */
    public function userDelete(){
        $params = $this->request()->post;
        $user = new User();
        $result = $user->delUserList($params);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }

    /**
     * 设置用户密码
     */
    public function userPassword(){
        $params = $this->request()->post;
        $user = new User();
        $result = $user->setUserPassword($params);
        return $this->responseJson($result);
    }


}