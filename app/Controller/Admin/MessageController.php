<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\Message;
use W7\App\Model\Common\MessageUser;
use W7\Http\Message\Server\Request;


class MessageController extends ControllerAbstract
{

    /**
     * 用户获取未读消息数
     * @access public
     * @param  array $data 外部数据
     * @return false|array
     * @throws
     */
    public function unread(){
        $message = new Message();
        $params = [

        ];
        $result = $message->getMessageUserUnread($params);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }
    public function getMessageUserList(){
        $message = new Message();
        $result = $message->getMessageUserList($this->request()->post);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }
    public function setMessageUserRead(){
        $message = new MessageUser();
        $result = $message->setMessageUserRead($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $message->error, 'data' => '']);
        }
    }
    public function setMessageUserAllRead(){
        $message = new MessageUser();
        $result = $message->setMessageUserAllRead($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $message->error, 'data' => '']);
        }
    }
    public function setMessageStatus(){
        $message = new Message();
        $result = $message->setMessageStatus($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $message->error, 'data' => '']);
        }
    }
    public function delMessageUserList(){
        $message = new MessageUser();
        $result = $message->delMessageUserList($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $message->error, 'data' => '']);
        }
    }
    public function delMessageUserAll(){
        $message = new MessageUser();
        $result = $message->delMessageUserAll($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $message->error, 'data' => '']);
        }
    }
    public function addMessageItem(){
        $message = new Message();
        $result = $message->addMessageItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $message->error, 'data' => '']);
        }
    }
    public function delMessageList(){
        $message = new Message();
        $result = $message->delMessageList($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $message->error, 'data' => '']);
        }
    }
    public function setMessageItem(){
        $message = new Message();
        $result = $message->setMessageItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $message->error, 'data' => '']);
        }
    }
    public function getMessageItem(){
        $message = new Message();
        $result = $message->getMessageItem($this->request()->post);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }
    public function getMessageUserItem(){
        $message = new Message();
        $result = $message->getMessageUserItem($this->request()->post);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }
    public function getMessageList(){
        $message = new Message();
        $result = $message->getMessageList($this->request()->post);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }
}