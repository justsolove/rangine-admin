<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\Admin;

class AdminController extends ControllerAbstract
{

    public function getAdminList(){
        $admin = new Admin();
        $result = $admin->getAdminList($this->request()->post);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }
    public function addAdminItem(){
        $admin = new Admin();
        $result = $admin->addAdminItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $admin->error, 'data' => '']);
        }
    }
    public function setAdminItem(){
        $admin = new Admin();
        $result = $admin->setAdminItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $admin->error, 'data' => '']);
        }
    }
    public function setAdminPassword(){
        $admin = new Admin();
        $result = $admin->setAdminPassword($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $admin->error, 'data' => '']);
        }
    }
    public function resetAdminItem(){
        $admin = new Admin();
        $result = $admin->resetAdminItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $admin->error, 'data' => '']);
        }
    }
    public function delAdminList(){
        $admin = new Admin();
        $result = $admin->delAdminList($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $admin->error, 'data' => '']);
        }
    }

    public function setAdminStatus(){
        $admin = new Admin();
        $result = $admin->setAdminStatus($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $admin->error, 'data' => '']);
        }
    }
}