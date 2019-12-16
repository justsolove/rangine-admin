<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\App\Model\Common\Base;
use W7\App\Model\Service\Config;
use W7\App\Exception\HttpException;

class Setting extends Base
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'setting';
   // 主键设置
    protected $primaryKey  = 'setting_id';
//    // 主键是否递增
//    protected $incrementing   = true;
//    // 主键是否 int
//    protected $keyType   = true;
//    // 是否自动管理 created_at 和 updated_at
    public $timestamps = false;

    protected $hidden = [
        'setting_id',
    ];


    /**
     * 获取某个模块的设置
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     */
    public function getSettingList($data)
    {

        $result = Config::get(null, $data['module']);
        foreach ($result as &$value) {
            $temp = json_decode($value['value'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $value['value'] = $temp;
            }
        }

        if (!is_empty_parm($data['code'])) {
            if (array_key_exists($data['code'], $result)) {
                return [$data['code'] => $result[$data['code']]];
            } else {
                return $this->setError('键名 '. $data['code'] . ' 不存在');
            }
        }

        return $result;
    }

    /**
     * 设置系统配置
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function setSystemList($data)
    {
        idb()->transaction(function () use ($data){
            foreach ($data['data'] as $key => $value) {
                switch ($key) {
                    case 'open_index':
                    case 'open_api':
                    case 'open_mobile':
                        !empty($value) ?: $value = 0;
                        $this->setSettingItem($key, $value, 'system_info', 'Setting.status');
                        break;

                    case 'close_reason':
                    case 'name':
                    case 'title':
                    case 'keywords':
                    case 'description':
                    case 'logo':
                    case 'miitbeian':
                    case 'miitbeian_url':
                    case 'miitbeian_ico':
                    case 'beian':
                    case 'beian_url':
                    case 'beian_ico':
                    case 'weixin_url':
                    case 'third_count':
                    case 'qrcode_logo':
                    case 'platform':
                        $this->setSettingItem($key, $value, 'system_info', 'Setting.string');
                        break;

                    case 'allow_origin':
                        !empty($value) ?: $value = [];
                        $this->setSettingItem($key, $value, 'system_info', 'Setting.array', true);
                        break;

                    default:
                        // 未授权，请重新登录(401)
                        throw new HttpException('键名' . $key . '不在允许范围内',500);
                       // throw new \Exception('键名' . $key . '不在允许范围内');
                }
            }
        });
        return true;
    }

    /**
     * 设置上传配置
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function setUploadList($data)
    {
        idb()->transaction(function () use ($data){
            foreach ($data['data'] as $key => $value) {
                switch ($key) {
                    case 'default':
                        $this->setSettingItem($key, $value, 'upload', 'Setting.default_oss');
                        break;

                    case 'file_size':
                        !empty($value) ?: $value = '0M';
                        $this->setSettingItem($key, $value, 'upload', 'Setting.string');
                        break;

                    case 'oss':
                    case 'image_ext':
                    case 'file_ext':
                    case 'ox_url':
                    case 'qiniu_access_key':
                    case 'qiniu_secret_key':
                    case 'qiniu_bucket':
                    case 'qiniu_url':
                    case 'aliyun_access_key':
                    case 'aliyun_secret_key':
                    case 'aliyun_bucket':
                    case 'aliyun_url':
                    case 'aliyun_endpoint':
                    case 'aliyun_rolearn':
                        $this->setSettingItem($key, $value, 'upload', 'Setting.string');
                        break;

                    default:
                        throw new HttpException('键名' . $key . '不在允许范围内',500);
                }
            }
            return true;
        });



    }
    /**
     * 设置小程序配置
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function setWxappList($data)
    {
        idb()->transaction(function () use ($data){
            foreach ($data['data'] as $key => $value) {
                switch ($key) {
                    case 'appid':
                    case 'appsecret':
                        $this->setSettingItem($key, $value, 'wxapp', 'Setting.string');
                        break;
                    default:
                        throw new HttpException('键名' . $key . '不在允许范围内',500);
                }
            }
            return true;
        });
    }
    /**
     * 设置小程序配置
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function setWebappList($data)
    {
        idb()->transaction(function () use ($data){
            foreach ($data['data'] as $key => $value) {
                switch ($key) {
                    case 'appid':
                        $this->setSettingItem($key, $value, 'webapp', 'Setting.string');
                        break;
                    default:
                        throw new HttpException('键名' . $key . '不在允许范围内',500);
                }
            }
            return true;
        });
    }
    /**
     * 设置某个模块下的配置参数
     * @access private
     * @param  string $key    键名
     * @param  mixed  $value  值
     * @param  string $module 模块
     * @param  string $rule   规则
     * @param  bool   $toJson 是否转为json
     * @throws \Exception
     */
    private function setSettingItem($key, $value, $module, $rule, $toJson = false)
    {

        $map[] = ['code','=', $key];
        $map[] = ['module','=', $module];

        !$toJson ?: $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        if (false === $this->where($map)->update(['value' => $value])) {
            throw new \Exception($this->getError());
        }

        Config::set($key . '.value', $value, $module);
    }



}