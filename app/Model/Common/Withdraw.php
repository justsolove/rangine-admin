<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class Withdraw extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'withdraw';
   // 主键设置
    protected $primaryKey  = 'withdraw_id';
//    // 主键是否递增
//    protected $incrementing   = true;
//    // 主键是否 int
//    protected $keyType   = true;
//    // 是否自动管理 created_at 和 updated_at
//    protected $timestamps    = false;

//    protected $hidden = [
//        'router',
//        'help_id',
//        'ver',
//        'module',
//    ];
    /**
     * hasOne ims_user
     * @access public
     * @return mixed
     */
    public function getUser()
    {
        return $this
            ->hasOne('W7\App\Model\Common\User', 'user_id', 'user_id');

    }

    /**
     * 获取提现请求列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getWithdrawList($data)
    {
        // 搜索条件
        $map = [];
        empty($data['withdraw_no']) ?: $map[] = ['withdraw.withdraw_no','=', $data['withdraw_no']];
        is_empty_parm($data['status']) ?: $map[] = ['withdraw.status','=', $data['status']];

        // 关联查询
        $with = [];
        // 后台管理搜索
        if (is_client_admin()) {
            $with = ['getUser:user_id,username,nickname,level_icon,head_pic'];
            //empty($data['account']) ?: $map[] = ['getUser.username|getUser.nickname','=', $data['account']];
        }else{
            $map[] = ['withdraw.user_id','=', get_client_id()];
        }

        $query = $this->with($with)->where($map);
        if (!empty($data['begin_time']) && !empty($data['end_time'])) {
            $query =  $query->whereBetween('create_time',[$data['begin_time'], $data['end_time']]);
        }
        if(is_client_admin() && !empty($data['account'])){
            $str = $data['account'];
            $query =  $query->orWhereHas ('getUser',function ($serch) use($str){
                $serch->where('username','=',$str);
            });
            $query =  $query->orWhereHas ('getUser',function ($serch) use($str){
                $serch->where('nickname','=',$str);
            });
        }
        $totalResult = $query->count();

        if ($totalResult <= 0) {
            return ['total_result' => 0];
        }


        // 每页条数
        $pageSize = isset($data['page_size']) ? $data['page_size'] : 25;
        // 翻页页数
        $pageNo = isset($data['page_no']) ? $data['page_no'] : 1;
        $pageCur = ($pageNo-1) * $pageSize;

        // 排序方式
        $orderType = !empty($data['order_type']) ? $data['order_type'] : 'asc';

        // 排序的字段
        $orderField = !empty($data['order_field']) ? $data['order_field'] : 'withdraw_id';

        $listResult = $query
            ->orderBy($orderField , $orderType)
            ->offset($pageCur)->limit($pageSize)
            ->get();

        if (false !== $listResult) {
            return ['items' => $listResult, 'total_result' => $totalResult];
        }
        return false;
    }




}