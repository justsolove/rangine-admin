<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/12/13
 * Time: 9:27
 */

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\Region;

class RegionController extends ControllerAbstract
{
    /**
     * 系统信息
     */
    public function regionList(){

        $params = $this->request()->post;
        $setting = new Region();
        $result = $setting->getRegionSonList($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);

    }

    /**
     * 新增区域
     */
    public function regionAdd(){
        $params = $this->request()->post;
        $setting = new Region();
        $result = $setting->addRegionItem($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }
    /**
     * 修改区域
     */
    public function regionSet(){
        $params = $this->request()->post;
        $setting = new Region();
        $result = $setting->setRegionItem($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }

    /**
     * 删除区域
     */
    public function regionDel(){
        $params = $this->request()->post;
        $setting = new Region();
        $result = $setting->delRegionList($params);
        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => $result]);
    }
    /**
     * 拖拽排序区域
     */
    public function regionIndex(){
        //$params = $this->request()->post;

        return $this->responseJson(['status'=> 200,'message' => "success", 'data' => '']);
    }

}