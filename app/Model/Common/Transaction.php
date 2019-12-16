<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class Transaction extends ModelAbstract
{

    /**
     * 收入
     * @var int
     */
    const TRANSACTION_INCOME = 0;

    /**
     * 支出
     * @var int
     */
    const TRANSACTION_EXPENDITURE = 1;

    /**
     * 是否需要自动写入时间戳
     * @var bool
     */
    protected $autoWriteTimestamp = true;

    /**
     * 更新日期字段
     * @var bool/string
     */
    protected $updateTime = false;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'transaction';
   // 主键设置
    protected $primaryKey  = 'transaction_id';
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
     * 获取交易结算列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getTransactionList($data)
    {


        // 搜索条件
        $map = [];
        is_empty_parm($data['type']) ?: $map[] = ['transaction.type','=', $data['type']];
        empty($data['source_no']) ?: $map[] = ['transaction.source_no','=', $data['source_no']];
        is_empty_parm($data['module']) ?: $map[] = ['transaction.module','=', $data['module']];
        empty($data['card_number']) ?: $map[] = ['transaction.card_number','=', $data['card_number']];

        // 关联查询
        $with = '';
        // 后台管理搜索
        if (is_client_admin()) {
            $with = ['getUser:user_id,username,nickname,level_icon,head_pic'];
            empty($data['action']) ?: $map[] = ['transaction.action','=', $data['action']];
            is_empty_parm($data['to_payment']) ?: $map[] = ['transaction.to_payment','=', $data['to_payment']];
            //empty($data['account']) ?: $map[] = ['getUser.username|getUser.nickname','=', $data['account']];
        }else{
            $map[] = ['transaction.user_id','=', get_client_id()];
        }

        // 获取总数量,为空直接返回 ->whereBetween('votes', [1, 100])
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
        $orderType = !empty($data['order_type']) ? $data['order_type'] : 'desc';



        // 排序的字段
        $orderField = !empty($data['order_field']) ? $data['order_field'] : 'transaction_id';

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