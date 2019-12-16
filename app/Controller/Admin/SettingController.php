<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\Setting;

class SettingController extends ControllerAbstract
{


    /**
     * 根据路由获取帮助
     */
    public function settingList(){
        $params = $this->request()->post;
        $setting = new Setting();
        $result = $setting->getSettingList($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }

    /**
     * 设置参数
     */
    public function setSystem(){
        $params = $this->request()->post;
        $setting = new Setting();
        $result = $setting->setSystemList($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }

    /**
     * 设置上传
     */
    public function setUpload(){
        $params = $this->request()->post;
        $setting = new Setting();
        $result = $setting->setUploadList($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }

    /**
     * 设置小程序
     */
    public function setWxapp(){
        $params = $this->request()->post;
        $setting = new Setting();
        $result = $setting->setWxappList($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }

    /**
     * 设置公众号
     */
    public function setWebapp(){
        $params = $this->request()->post;
        $setting = new Setting();
        $result = $setting->setWebappList($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }



}