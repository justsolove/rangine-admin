<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/13
 * Time: 14:23
 */

namespace W7\App\Controller\Wxapp;

use W7\Core\Controller\ControllerAbstract;
use W7\Http\Message\Server\Request;

class IndexController  extends ControllerAbstract {
    /**
     * login
     */
    public function index(){

        return $this->responseJson(['sdfsdf',['sdfsfd']]);
    }
    public function test(){
        return $this->responseJson(['sdfsdf',['sdfsfd']]);
    }
    public function chack(Request $request){
        $request->session->set('test', 1);
        $request->session->set('test1', ['key' => 'value']);
        return $this->responseJson(['chack',['chack']]);
    }

}