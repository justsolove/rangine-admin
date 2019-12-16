<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\AuthGroup;

class AuthController extends ControllerAbstract
{

    /**
     * 用户获取未读消息数
     * @access public
     * @param  array $data 外部数据
     * @return false|array
     * @throws
     */
    public function authList(){
        $group = new AuthGroup();
        $params = [];
        isset($this->request()->post['exclude_id']) ? $params['exclude_id'] = $this->request()->post['exclude_id'] : '';
        is_empty_parm($this->request()->post['status']) ?: $params['status'] = $this->request()->post['status'] ;
        // 排序方式
        $params['order_type'] = !empty($this->request()->post['order_type']) ? $this->request()->post['order_type'] : 'asc';
        // 排序的字段
        $params['order_field'] = !empty($this->request()->post['order_field']) ? $this->request()->post['order_field'] : 'group_id';
        $result = $group->getAuthGroupList($params);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }
    /**
     * 编辑
     * @access public
     * @param  array $data 外部数据
     * @return false|array
     * @throws
     */
    public function authSave(){
        $group = new AuthGroup();
        $result=$group->setAuthGroupItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => '操作失败', 'data' => '']);
        }
    }
    /**
     * 排序
     * @access public
     * @param  array $data 外部数据
     * @return false|array
     * @throws
     */
    public function authSortSave(){
        $group = new AuthGroup();
        $result=$group->setAuthGroupSort($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => '操作失败', 'data' => '']);
        }
    }

    public function authAdd(){
        $group = new AuthGroup();
        $result=$group->addAuthGroupItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => '添加失败', 'data' => '']);
        }
    }
    public function authDel(){
        $group = new AuthGroup();
        $result=$group->delAuthGroupItem($this->request()->post);
        if($result===true){
            return $this->responseJson(['status'=> 200,'message' => '操作成功', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' =>$group->error, 'data' => '']);
        }
    }
    public function authStatusSave(){
        $group = new AuthGroup();
        $result=$group->setAuthGroupStatus($this->request()->post);
        if($result===true){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => '修改失败', 'data' =>$result]);
        }

    }
}