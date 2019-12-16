<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class Help extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'help';
   // 主键设置
    protected $primaryKey  = 'help_id';
//    // 主键是否递增
//    protected $incrementing   = true;
//    // 主键是否 int
//    protected $keyType   = true;
//    // 是否自动管理 created_at 和 updated_at
//    protected $timestamps    = false;

    protected $hidden = [
        'router',
        'help_id',
        'ver',
        'module',
    ];

    /**
     * 根据路由获取帮助文档
     * @access public
     * @param  array $data 外部数据
     * @return bool|array
     * @throws
     */
    public function getHelpRouter($data)
    {
       return  self::get()
            ->where('router',$data['router'])
            ->where('ver',$data['ver'])
            ->where('module',$data['module'])
            ->first() ?: '';
    }



}