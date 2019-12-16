<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
use W7\App\Model\Common\Base;
class PaymentLog extends Base
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'payment_log';
   // 主键设置
    protected $primaryKey  = 'payment_log_id';
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
     * 生成唯一交易流水号
     * @access private
     * @return string
     */
    private function getPaymentNo()
    {
        do {
            $paymentNo = get_order_no('ZF_');
        } while (self::checkUnique([['payment_no','=', $paymentNo]]));
        return $paymentNo;
    }

    /**
     * 获取充值记录列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getPaymentLogList($data)
    {

        // 搜索条件
        $map = [];
        empty($data['payment_no']) ?: $map[] = ['payment_log.payment_no','=', $data['payment_no']];
        empty($data['order_no']) ?: $map[] = ['payment_log.order_no','=', $data['order_no']];
        empty($data['out_trade_no']) ?: $map[] = ['payment_log.out_trade_no','=', $data['out_trade_no']];
        is_empty_parm($data['type']) ?: $map[] = ['payment_log.type','=', $data['type']];
        is_empty_parm($data['status']) ?: $map[] = ['payment_log.status','=', $data['status']];
        // 关联查询
        $with = [];
        if (is_client_admin()) {
            $with = ['getUser:user_id,username,nickname,level_icon,head_pic'];
            is_empty_parm($data['to_payment']) ?: $map[] = ['payment_log.to_payment','=', (string)$data['to_payment']];
        }else{
            $map[] = ['payment_log.user_id','=', get_client_id()];
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


        // 获取总数量,为空直接返回
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
        $orderField = !empty($data['order_field']) ? $data['order_field'] : 'payment_log_id';

        $result = $query
            ->orderBy($orderField , $orderType)
            ->offset($pageCur)->limit($pageSize)
            ->get();

        if (false !== $result) {
            return ['items' => $result->toArray(), 'total_result' => $totalResult];
        }

        return false;
    }






}