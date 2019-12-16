<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/12/12
 * Time: 15:29
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;

class Base extends ModelAbstract
{
    // 错误信息
    protected $error;

    /**
     * 设置模型错误信息
     * @access public
     * @param  string $value 错误信息
     * @return false
     */
    public function setError($value)
    {
        $this->error = $value;
        return false;
    }

    /**
     * 返回模型的错误信息
     * @access public
     * @return string|array
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 检测是否存在相同值
     * @access public
     * @param  array $map 查询条件
     * @return bool false:不存在
     * @throws
     */
    public static function checkUnique($map)
    {
        if (empty($map)) {
            return true;
        }

        return self::where($map)->exists();

    }


}