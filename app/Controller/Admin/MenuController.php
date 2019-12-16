<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\Menu;

class MenuController extends ControllerAbstract
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
    public function authList(){
        $menu = new Menu();
        $result = $menu->getMenuAuthList(['module' => 'admin','platform' => 'admin']);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }

    /**
     * 获取Menu
     */
    public function getMenuList(){
        $menu = new Menu();
        $result = $menu->getMenuList($this->request()->post);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }
    /**
     * 编辑保存
     */
    public function setMenuItem(){
        $menu = new Menu();
        $result = $menu->setMenuItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $menu->error, 'data' => '']);
        }
    }
    /**
     * 添加
     */
    public function addMenuItem(){
        $menu = new Menu();
        $result = $menu->addMenuItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $menu->error, 'data' => '']);
        }
    }

    /**
     * 添加
     */
    public function setMenuStatus(){
        $menu = new Menu();
        $result = $menu->setMenuStatus($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $menu->error, 'data' => '']);
        }
    }
    /**
     * 删除
     */
    public function delMenuItem(){
        $menu = new Menu();
        $result = $menu->delMenuItem($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $menu->error, 'data' => '']);
        }
    }
    public function setMenuIndex(){
        $menu = new Menu();
        $result = $menu->setMenuIndex($this->request()->post);
        if($result){
            return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
        }else{
            return $this->responseJson(['status'=> 500,'message' => $menu->error, 'data' => $result]);
        }
    }

}