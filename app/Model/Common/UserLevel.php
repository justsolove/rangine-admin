<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class UserLevel extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'user_level';

    public $timestamps    = false;

    public $primaryKey  = 'user_level_id';
    public $incrementing   = true;
    /**
     * 获取账号等级列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getLevelList($data)
    {
        // 排序方式
        $orderType = !empty($data['order_type']) ? $data['order_type'] : 'asc';

        // 排序的字段
        $orderField = !empty($data['order_field']) ? $data['order_field'] : 'amount';

        return  self::orderBy($orderField,$orderType)->get()->toArray();


    }

    /**
     * 批量删除账号等级
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function delLevelList($data)
    {
        if(idb()->table('user')->whereIn('user_level_id',$data['user_level_id'])->exists()){
            return '等级已在使用中,建议进行编辑修改';
        }

        self::delete($data['user_level_id']);

        return true;
    }


}