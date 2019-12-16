<?php
use W7\App;
// 系统默认权限
define('AUTH_SUPER_ADMINISTRATOR', 1);
define('AUTH_ADMINISTRATOR', 2);
define('AUTH_CLIENT', 3);
define('AUTH_GUEST', 4);

/**
 * 公共函数，已加载
 */
if (!function_exists('user_md5')) {
    /**
     * 非常规用户密码加盐处理
     * @param  string $password 明文
     * @param  string $key      盐
     * @return string
     */
    function user_md5($password, $key = 'oxiang#')
    {
        return isset($password) ? md5(sha1($password) . $key) : '';
    }
}

if (!function_exists('get_order_no')) {
    /**
     * 生成唯一订单号
     * @param  string $prefix 头部
     * @return string
     */
    function get_order_no($prefix = 'CS_')
    {
        $year_code = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

        $order_no = $prefix;
        $order_no .= $year_code[(intval(date('Y')) - 1970) % 10];
        $order_no .= mb_strtoupper(dechex(date('m')), 'utf-8');
        $order_no .= date('d') . mb_substr(time(), -5, null, 'utf-8');
        $order_no .= mb_substr(microtime(), 2, 5, 'utf-8');
        $order_no .= sprintf('%02d%04d', mt_rand(0, 99), get_client_id());

        return $order_no;
    }
}

if (!function_exists('rand_number')) {
    /**
     * 产生随机数值
     * @param  int $len 数值长度,默认8位
     * @return string
     */
    function rand_number($len = 8)
    {
        $chars = str_repeat('123456789', 3);
        if ($len > 10) {
            $chars = str_repeat($chars, $len);
        }

        $chars = str_shuffle($chars);
        $number = mb_substr($chars, 0, $len, 'utf-8');

        return $number;
    }
}

if (!function_exists('rand_string')) {
    /**
     * 随机产生数字与字母混合且小写的字符串(唯一)
     * @param  int  $len   数值长度,默认32位
     * @param  bool $lower 是否小写,否则大写
     * @return string
     */
    function rand_string($len = 32, $lower = true)
    {
        $string = mb_substr(md5(uniqid(rand(), true)), 0, $len, 'utf-8');
        return $lower ? $string : mb_strtoupper($string, 'utf-8');
    }
}

if (!function_exists('get_randstr')) {
    /**
     * 产生数字与字母混合随机字符串
     * @param  int $len 数值长度,默认6位
     * @return string
     */
    function get_randstr($len = 6)
    {
        $chars = [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
            'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
            'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G',
            'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
            'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2',
            '3', '4', '5', '6', '7', '8', '9',
        ];

        $charsLen = count($chars) - 1;
        shuffle($chars);

        $output = '';
        for ($i = 0; $i < $len; $i++) {
            $output .= $chars[mt_rand(0, $charsLen)];
        }

        return $output;
    }
}

if (!function_exists('auto_hid_substr')) {
    /**
     * 智能字符串模糊化
     * @param  string $str 被模糊的字符串
     * @param  int    $len 模糊的长度
     * @return string
     */
    function auto_hid_substr($str, $len = 3)
    {
        if (empty($str)) {
            return null;
        }

        $sub_str = mb_substr($str, 0, 1, 'utf-8');
        for ($i = 0; $i < $len; $i++) {
            $sub_str .= '*';
        }

        if (mb_strlen($str, 'utf-8') <= 2) {
            $str = $sub_str;
        }

        $sub_str .= mb_substr($str, -1, 1, 'utf-8');
        return $sub_str;
    }
}

if (!function_exists('string_to_byte')) {
    /**
     * 字符计量大小转换为字节大小
     * @param  string $var 值
     * @param  int    $dec 小数位数
     * @return int
     */
    function string_to_byte($var, $dec = 2)
    {
        preg_match('/(^[0-9\.]+)(\w+)/', $var, $info);
        $size = $info[1];
        $suffix = mb_strtoupper($info[2], 'utf-8');

        $a = array_flip(['B', 'KB', 'MB', 'GB', 'TB', 'PB']);
        $b = array_flip(['B', 'K', 'M', 'G', 'T', 'P']);

        $pos = array_key_exists($suffix, $a) && $a[$suffix] !== 0 ? $a[$suffix] : $b[$suffix];
        return round($size * pow(1024, $pos), $dec);
    }
}

if (!function_exists('xml_to_array')) {
    /**
     * XML转为array
     * @param  mixed $xml 值
     * @return array
     */
    function xml_to_array($xml)
    {
        // 禁止引用外部xml实体
        $value = false;
        libxml_disable_entity_loader(true);

        if (is_string($xml)) {
            $value = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        } else if (is_object($xml)) {
            $value = json_decode(json_encode($xml), true);
        }

        return $value;
    }
}

if (!function_exists('unique_and_delzero')) {
    /**
     * 先去除重复数值,再移除0值
     * @param  array $var 数组
     * @return void
     */
    function unique_and_delzero(&$var)
    {
        if (!is_array($var) || empty($var)) {
            return;
        }

        $var = array_unique($var);
        $zeroKey = array_search(0, $var);

        if (false !== $zeroKey) {
            unset($var[$zeroKey]);
        }
    }
}

if (!function_exists('is_empty_parm')) {
    /**
     * 判断是否为空参数
     * @param  mixed $parm
     * @return bool
     */
    function is_empty_parm(&$parm)
    {
        return !(isset($parm) && '' !== $parm);
    }
}

if (!function_exists('get_client_id')) {
    /**
     * 返回当前账号编号
     * @return int
     */
    function get_client_id()
    {
        $client = App::getApp()->getContainer()->get('client');
        return isset($client['client_id']) ? $client['client_id'] : 0;
    }
}

if (!function_exists('get_client_type')) {
    /**
     * 返回当前账号类型
     * @return int -1:游客 0:顾客 1:管理组
     */
    function get_client_type()
    {
        $visitor = iconfig()->getUserConfig('params')['clint_group']['visitor']['value'];
        $client = App::getApp()->getContainer()->get('client');
        return isset($client['type']) ? $client['type'] : $visitor;
    }
}

if (!function_exists('is_client_admin')) {
    /**
     * 当前账号是否属于管理组
     * @return bool
     */
    function is_client_admin()
    {
        $admin = iconfig()->getUserConfig('params')['clint_group']['admin']['value'];
        return get_client_type() === $admin;
    }
}

if (!function_exists('get_client_id')) {
    /**
     * 返回当前账号编号
     * @return int
     */
    function get_client_id()
    {
        $client = App::getApp()->getContainer()->get('client');
        return isset($client['client_id']) ? $client['client_id'] : 0;
    }
}

if (!function_exists('get_client_name')) {
    /**
     * 返回当前账号登录名
     * @return int
     */
    function get_client_name()
    {
        $client = App::getApp()->getContainer()->get('client');
        return isset($client['client_name']) ? $client['client_name'] : '游客';
    }
}

if (!function_exists('get_client_nickname')) {
    /**
     * 返回当前账号昵称
     * @return mixed
     */
    function get_client_nickname()
    {
        if (get_client_group() == AUTH_GUEST) {
            return '游客';
        }

        $userType = is_client_admin() ? 'admin' : 'user';
        $map['user_id'] = ['eq', get_client_id()];

      //  return db($userType)->where($map)->value('nickname', '');
        return '';
    }
}

if (!function_exists('get_client_group')) {
    /**
     * 返回当前账号用户组编号
     * @return int
     */
    function get_client_group()
    {
        $client = App::getApp()->getContainer()->get('client');
        return isset($client['group_id']) ? $client['group_id'] : AUTH_GUEST;
    }
}

