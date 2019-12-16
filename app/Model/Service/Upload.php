<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Service;

use W7\Core\Helper\StringHelper;
use W7\App\Model\Service\Config;
use W7\App\Model\Common\Storage;
use W7\App;
class Upload
{
    /**
     * 控制器错误信息
     * @var string
     */
    public $error;

    public $request;

    /**
     * 构造函数
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->request = App::getApp()->getContext()->getRequest();
    }


    /*
     * 设置错误信息
     * @access public
     * @param  string $value 错误信息
     * @return false
     */
    public function setError($value)
    {
        $this->error = $value;
        return false;
    }

    /*
     * 获取错误信息
     * @access public
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 获取上传模块列表
     * @access public
     * @return array
     */
    public function getUploadModule()
    {
        $moduleList = [
            [
                'name'    => \W7\App\Helper\oss\ox\Upload::NAME,
                'module'  => \W7\App\Helper\oss\ox\Upload::MODULE,
                'default' => 0,
            ],
            [
                'name'    =>  \W7\App\Helper\oss\qiniu\Upload::NAME,
                'module'  => \W7\App\Helper\oss\qiniu\Upload::MODULE,
                'default' => 0,
            ]
        ];
        $default = Config::get('default.value', 'upload');
        foreach ($moduleList as &$module) {
            if ($default === $module['module']) {
                $module['default'] = 1;
                break;
            }
        }
        return $moduleList;
    }

    /**
     * 创建资源上传对象
     * @access public
     * @param  string $file  目录
     * @param  string $model 模块
     * @return object|false
     */
    public function createOssObject($file, $model = 'Upload')
    {
        // 转换模块的名称
        $file = StringHelper::lower($file);
        $model = StringHelper::studly($model);

        if (empty($file) || empty($model)) {
            return $this->setError('资源目录或模块不存在');
        }

        $ossObject = '\\W7\\App\\Helper\\oss\\' . $file . '\\' . $model;
        if (class_exists($ossObject)) {
            return new $ossObject;
        }

        return $this->setError($ossObject . '模块不存在');
    }

    /**
     * 获取上传地址
     * @access public
     * @return mixed
     */
    public function getUploadUrl()
    {
        $file = $this->getModuleName();

        if (false === $file) {
            return false;
        }

        $ossObject = $this->createOssObject($file);
        if (false === $ossObject) {
            return false;
        }

        $result = $ossObject->getUploadUrl();
        if (false === $result) {
            return $this->setError($ossObject->getError());
        }

        return $result;
    }

    /**
     * 获取上传Token
     * @access public
     * @return mixed
     */
    public function getUploadToken($params)
    {
        $file = $this->getModuleName($params);
        if (false === $file) {
            return false;
        }

        $ossObject = $this->createOssObject($file);
        //idd($ossObject);
        if (false === $ossObject) {
            return false;
        }

        $result = $ossObject->getToken();
        if (false === $result) {
            return $this->setError($ossObject->getError());
        }

        // 附加可上传后缀及附件大小限制
        $result['image_ext'] = Config::get('image_ext.value', 'upload');
        $result['file_ext'] = Config::get('file_ext.value', 'upload');
        $result['file_size'] = Config::get('file_size.value', 'upload');

        return $result;
    }

    /**
     * 当参数为空时获取默认上传模块名,否则验证指定模块名并返回
     * @access public
     * @return string|false
     */
    private function getModuleName($params)
    {
        $module = $params['module'];

        if (empty($module)) {
            return Config::get('default.value', 'upload');
        }

        $moduleList = array_column($this->getUploadModule(), 'module');
        if (!in_array($module, $moduleList)) {
            return false;
        }

        return $module;
    }

    /**
     * 资源上传请求(第三方OSS只能单文件直传方式上传)
     * @access public
     * @return mixed
     */
    public function addUploadList( $module_name = 'admin' )
    {
        $ossObject = $this->createOssObject('ox');
        if (false === $ossObject) {
            return false;
        }
        $result = $ossObject->uploadFiles($module_name);
        if (false === $result) {
            return $this->setError($ossObject->getError());
        }else{
            if($module_name=='admin'){
                $rs = Storage::createImg($result);
                if(!$rs){
                    return $this->setError('上传失败!');
                }
            }
        }
        return $result;
    }

    /**
     * 获取资源缩略图
     * @access public
     * @return mixed
     */
    public function getThumb()
    {
        $url = $this->getThumbUrl();
        if (false === $url) {
            $request = Request::instance();
            $oldUrl = $request->param('url');

            header('Location:' . $oldUrl, true, 301);
            exit;
        }

        if (empty($url['url_prefix'])) {
            header('status: 404 Not Found', true, 404);
        } else {
            header('Location:' . $url['url_prefix'], true, 301);
        }

        exit;
    }

    /**
     * 获取资源缩略图实际路径
     * @access public
     * @param  bool $getObject 是否返回OSS组件对象
     * @return mixed
     */
    public function getThumbUrl($getObject = false)
    {
        // 补齐协议地址
        $request = Request::instance();
        $url = $request->param('url');

        $pattern = '/^((http|https)?:\/\/)/i';
        if (!preg_match($pattern, $url)) {
            $url = ($request->isSsl() ? 'https://' : 'http://') . $url;
        }

        // 从URL分析获取对应模型
        $urlArray = parse_url($url);
        if (!isset($urlArray['query'])) {
            return $this->setError('请填写合法的url参数');
        }

        parse_str($urlArray['query'], $items);
        if (!array_key_exists('type', $items)) {
            return $this->setError('type参数值不能为空');
        }

        $pact = array_column($this->getUploadModule(), 'module');
        if (!in_array($items['type'], $pact)) {
            return $this->setError('type协议错误');
        }

        // 是否定义资源样式
        if ($request->has('code', 'param', true)) {
            $style = new StorageStyle();
            $styleResult = $style->getStorageStyleCode(['code' => $request->param('code')]);

            if ($styleResult) {
                foreach ($styleResult as $key => $value) {
                    if ('scale' === $key) {
                        $isMobile = $request->isMobile() ? 'mobile' : 'pc';
                        if (array_key_exists($isMobile, $value)) {
                            $request->get($value[$isMobile]);
                        }

                        continue;
                    }

                    $request->get([$key => $value]);
                }
            }
        }

        $ossObject = $this->createOssObject($items['type']);
        if (false === $ossObject) {
            return false;
        }

        $url = $ossObject->getThumbUrl($urlArray);
        $notPrefix = preg_replace($pattern, '', $url);

        $data = [
            'source'     => $items['type'],
            'url'        => $notPrefix,
            'url_prefix' => strval($url),
        ];

        if (is_bool($getObject) && $getObject) {
            $data['ossObject'] = &$ossObject;
        }

        return $data;
    }

}