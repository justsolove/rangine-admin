<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\AuthRule;

class AuthRuleController extends ControllerAbstract
{
    public function getAuthRuleList(){
        $authRule = new AuthRule();
        $result = $authRule->getAuthRuleList($this->request()->post);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }
    public function setAuthRuleItem(){
        $authRule = new AuthRule();
        $result = $authRule->setAuthRuleItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $authRule->error, 'data' => $result]);
        }
    }
    public function addAuthRuleItem(){
        $authRule = new AuthRule();
        $result = $authRule->addAuthRuleItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $authRule->error, 'data' => $result]);
        }
    }
    public function setAuthRuleStatus(){
        $authRule = new AuthRule();
        $result = $authRule->setAuthRuleStatus($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $authRule->error, 'data' => $result]);
        }
    }

    public function delAuthRuleList(){
        $authRule = new AuthRule();
        $result = $authRule->delAuthRuleList($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $authRule->error, 'data' => $result]);
        }
    }

    public function setAuthRuleIndex(){
        $authRule = new AuthRule();
        $result = $authRule->setAuthRuleIndex($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $authRule->error, 'data' => $result]);
        }
    }
}